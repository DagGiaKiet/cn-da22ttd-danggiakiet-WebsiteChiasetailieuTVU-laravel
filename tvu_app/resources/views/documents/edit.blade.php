@extends('layouts.app')
@section('content')
<div class="container">
  <h3>Sửa tài liệu</h3>
  <form method="POST" action="{{ route('documents.update', $document) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row mb-3">
      <div class="col-md-6">
        <label class="form-label">Tên tài liệu</label>
        <input name="ten_tai_lieu" class="form-control" value="{{ old('ten_tai_lieu', $document->ten_tai_lieu) }}" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Ảnh bìa</label>
        <input type="file" name="hinh_anh" class="form-control" accept="image/*">
      </div>
    </div>
    <div class="mb-3">
      <label class="form-label">Mô tả</label>
      <textarea name="mo_ta" class="form-control" rows="4">{{ old('mo_ta', $document->mo_ta) }}</textarea>
    </div>
    <div class="row mb-3">
      <div class="col-md-4">
        <label class="form-label">Khoa</label>
        <select name="khoa_id" class="form-select" required>
          @foreach($khoas as $k)
            <option value="{{ $k->id }}" @selected($document->khoa_id==$k->id)>{{ $k->ten_khoa }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Ngành</label>
        <select name="nganh_id" class="form-select" required>
          @foreach($nganhs as $n)
            <option value="{{ $n->id }}" @selected($document->nganh_id==$n->id)>{{ $n->ten_nganh }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Môn học</label>
        <select name="mon_id" class="form-select" required>
          @foreach($mons as $m)
            <option value="{{ $m->id }}" @selected($document->mon_id==$m->id)>{{ $m->ten_mon }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="row mb-3">
      <div class="col-md-4">
        <label class="form-label">Hình thức</label>
        @php $loaiOld = old('loai', $document->loai); @endphp
        <select name="loai" id="loaiSelect" class="form-select">
          <option value="cho" @selected($loaiOld==='cho')>Miễn phí</option>
          <option value="ban" @selected($loaiOld==='ban')>Bán lại giá rẻ</option>
        </select>
      </div>
      <div class="col-md-4" id="giaGroup">
        <label class="form-label">Giá (đ)</label>
        <input type="number" step="1000" min="0" name="gia" id="giaInput" class="form-control" value="{{ old('gia',$document->gia) }}">
      </div>
      <div class="col-md-4">
        <label class="form-label">Trạng thái</label>
        <select name="trang_thai" class="form-select">
          <option value="available" @selected($document->trang_thai==='available')>Còn</option>
          <option value="sold" @selected($document->trang_thai==='sold')>Đã bán</option>
        </select>
      </div>
    </div>
    <button class="btn btn-primary">Lưu</button>
  </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
  const select = document.getElementById('loaiSelect');
  const group = document.getElementById('giaGroup');
  const input = document.getElementById('giaInput');
  function syncPriceVisibility(){
    const isBan = select.value === 'ban';
    if (isBan) {
      group.classList.remove('d-none');
      group.classList.remove('hidden');
      input.removeAttribute('disabled');
      input.setAttribute('required','required');
      if (!input.value || Number(input.value) <= 0) input.value = '';
    } else {
      group.classList.add('d-none');
      group.classList.add('hidden');
      input.setAttribute('disabled','disabled');
      input.removeAttribute('required');
      input.value = 0;
    }
  }
  select.addEventListener('change', syncPriceVisibility);
  syncPriceVisibility();
});
</script>
@endpush
