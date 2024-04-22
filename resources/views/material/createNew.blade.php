<form method="POST" action="{{ route('material-update-item') }}">
    @csrf
    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="description" class="form-label">ประเภทหมวดหมู่</label>
            <select class="form-select  @error('type') is-invalid @enderror" onchange="getCategories(this.value)"
                name="type" aria-label="Default select example" required>
                <option selected disabled>เลือกหมวดหมู่</option>
                <option value="1">วัสดุ</option>

            </select>
            @error('type')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="mb-3 col-md-6">
            <label for="categories_id" class="form-label">หมวดหมู่</label>
            <select class="form-select" onchange="getGroup(this.value)" name="group_id" id="group_id"
                aria-label="Default select example">
                <option selected>เลือกหมวดหมู่</option>
            </select>
        </div>
        <div class="mb-3 col-md-6">
            <label for="buy_name" class="form-label">ชื่อวัสดุ</label>
            {{--  <input id="buy_name" type="text"
                class="form-control @error('buy_name') is-invalid @enderror" name="buy_name"
                required placeholder="ชื่อวัสดุ" autocomplete="buy_name" readonly> --}}
            <select class="form-select" name="buy_name" id="buy_name" aria-label="Default select example">
                <option selected>เลือกชื่อวัสดุ</option>
            </select>
            @error('buy_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>
        <div class="mb-3 col-md-6">
            <label for="categories_id" class="form-label">รหัสวัสดุ</label>
            <input id="categories_id2" type="text" class="form-control @error('categories_id') is-invalid @enderror"
                name="categories_id" required placeholder="id" autocomplete="categories_id" readonly>

            @error('categories_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>
        <div class="mb-3 col-md-6" style="display: none">
            <label for="categories_id" class="form-label" id="id-group">code-id</label>
            <input id="code-id" type="text" class="form-control @error('code-id') is-invalid @enderror"
                name="code_id" required placeholder="id" autocomplete="code-id" readonly>

            @error('categories_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>

        <div class="mb-3 col-md-6">
            <label for="quantity" class="form-label">จำนวน</label>
            <input type="number" oninput="calculateTotalPrice2()"
                class="form-control @error('quantity') is-invalid @enderror quantityBuy" id="quantityBuy"
                name="quantity" placeholder="จำนวน" autocomplete="quantity" min="0">

            @error('quantity')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>
        <div class="mb-3 col-md-6">
            <label for="counting_unit" class="form-label">หน่วยนับ</label>
            <input id="counting_unit" type="text" class="form-control @error('counting_unit') is-invalid @enderror"
                name="counting_unit" placeholder="หน่วยนับ" required autocomplete="counting_unit" readonly>

            @error('counting_unit')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>
        <div class="mb-3 col-md-6">
            <label for="price_per" class="form-label">ราคาต่อ (ชิ้น,หน่วย,อื่นๆ)</label>
            <input id="price_perBuy" oninput="calculateTotalPrice2()" type="number"
                class="form-control price_perBuy @error('price_per') is-invalid @enderror" name="price_per"
                placeholder="ราคาต่อ (ชิ้น,อื่นๆ)" min="1" required autocomplete="price_per">

            @error('price_per')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>
        <div class="mb-3 col-md-6">
            <label for="total_price" class="form-label">ราคารวม</label>
            <input id="total_priceBuy" type="number" class="form-control @error('total_price') is-invalid @enderror"
                name="total_price" required placeholder="ชื่อเรียกจำนวนนับวัสดุ" min="1"
                autocomplete="total_price">

            @error('total_price')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>
        {{--       <div class="mb-3 col-md-6">
            <label for="warranty_period" class="form-label">ระยะเวลประกัน</label>

            <input class="date form-control" type="text" name="warranty_period" placeholder="dd-mm-yyyy">

            @error('warranty_period')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div> --}}
        <div class="mb-3 col-md-6">
            <label for="code_material_storage" class="form-label">ที่เก็บวัสดุ</label>
            <select class="form-select" aria-label="Default select example" id="code_material_storage"
                name="code_material_storage" required>

            </select>
        </div>

    </div>
    <div class="mt-2">
        <button type="submit" class="btn btn-primary me-2">บักทึก</button>
    </div>
</form>
