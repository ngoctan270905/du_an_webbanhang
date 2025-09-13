<?php

namespace App\Http\Controllers;

use App\Models\Return;
use App\Models\ReturnDetail;
use App\Models\ReturnModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReturnController extends Controller
{
  public function index(Request $request)
  {
    $query = ReturnModel::with(['order', 'user', 'returnDetails.orderDetail.product']);

    // Tìm kiếm theo mã trả hàng
    if ($search = $request->query('search')) {
      $query->where('ma_tra_hang', 'like', "%{$search}%");
    }

    // Lọc theo trạng thái
    if ($status = $request->query('status')) {
      $query->where('trang_thai', $status);
    }

    $returns = $query->latest()->paginate(10);

    return view('admin.returns.index', [
      'returns' => $returns,
    ]);
  }

  public function updateStatus(Request $request, $id)
  {
    $request->validate([
      'trang_thai' => 'required|in:pending,approved,rejected,completed,cancelled',
      'ghi_chu_admin' => 'nullable|string|required_if:trang_thai,rejected,cancelled',
    ]);

    $return = ReturnModel::findOrFail($id);

    // Kiểm tra chuyển đổi trạng thái hợp lệ
    $currentStatus = $return->trang_thai;
    $newStatus = $request->trang_thai;
    $validTransitions = [
      'pending' => ['approved', 'rejected', 'cancelled'],
      'approved' => ['completed', 'cancelled'],
      'rejected' => [],
      'completed' => [],
      'cancelled' => [],
    ];

    if (!in_array($newStatus, $validTransitions[$currentStatus] ?? [])) {
      Log::warning('Invalid return status transition:', [
        'return_id' => $return->id,
        'current_status' => $currentStatus,
        'new_status' => $newStatus,
      ]);
      return redirect()->route('admin.returns.index')
        ->with('error', "Không thể chuyển từ trạng thái '$currentStatus' sang '$newStatus'.");
    }

    DB::beginTransaction();
    try {
      $updateData = [
        'trang_thai' => $newStatus,
        'ghi_chu_admin' => in_array($newStatus, ['rejected', 'cancelled']) ? $request->ghi_chu_admin : null,
      ];

      // Cập nhật ngày hoàn tiền nếu trạng thái là completed
      if ($newStatus === 'completed') {
        $updateData['ngay_hoan_tien'] = now();
      }

      $return->update($updateData);

      Log::info('Return status updated:', [
        'return_id' => $return->id,
        'new_status' => $newStatus,
        'ghi_chu_admin' => $request->ghi_chu_admin,
        'ngay_hoan_tien' => $newStatus === 'completed' ? $updateData['ngay_hoan_tien'] : null,
      ]);

      DB::commit();
      return redirect()->route('admin.returns.index')
        ->with('success', 'Cập nhật trạng thái yêu cầu trả hàng thành công.');
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error('Error updating return status:', [
        'message' => $e->getMessage(),
        'trace' => $e->getTraceAsString(),
      ]);
      return redirect()->route('admin.returns.index')
        ->with('error', 'Có lỗi xảy ra khi cập nhật trạng thái: ' . $e->getMessage());
    }
  }

  public function show($id)
  {
    $return = ReturnModel::with([
      'order',
      'user',
      'returnDetails.orderDetail.product'
    ])->findOrFail($id);

    return view('admin.returns.show', [
      'return' => $return,
    ]);
  }
}
