<form method="POST" action="{{ route('buy-store') }}">
    @csrf
    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="description" class="form-label">ประเภทหมวดหมู่</label>
            <select class="form-select  @error('type') is-invalid @enderror" onchange="getCategories(this.value)"
                name="type" aria-label="Default select example" required>
                <option selected disabled>เลือกหมวดหมู่</option>
                <option value="2">ครุภัณฑ์</option>

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
            <label for="buy_name" class="form-label">ชื่อครุภัณฑ์</label>

            <select class="form-select" name="buy_durable_name" id="buy_durable_name"
                aria-label="Default select example">
                <option selected>เลือกชื่อครุภัณฑ์</option>
            </select>
            @error('buy_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>
        <div class="mb-3 col-md-6">
            <label for="buy_name" class="form-label">รายละเอียดชื่อครุภัณฑ์</label>

            <select class="form-select" name="durableArticles_name" id="durableArticles_name"
                aria-label="Default select example">
                <option selected>เลือกครุภัณฑ์</option>
            </select>


        </div>
        {{--   <div class="mb-3 col-md-6">
            <label for="categories_id" class="form-label" id="id-group">id</label>
            <input id="categories_id" type="text" class="form-control @error('categories_id') is-invalid @enderror"
                name="categories_id" required placeholder="id" autocomplete="categories_id" readonly>

            @error('categories_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div> --}}
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
            <input type="number" oninput="calculateTotalPrice(this)"
                class="form-control quantity @error('quantity') is-invalid @enderror" name="quantity"
                placeholder="จำนวน" autocomplete="quantity" min="0">

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
            <input oninput="calculateTotalPrice(this)" type="number"
                class="form-control price_per @error('price_per') is-invalid @enderror" name="price_per"
                placeholder="ราคาต่อ (ชิ้น,อื่นๆ)" min="1" required autocomplete="price_per">

            @error('price_per')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>
        <div class="mb-3 col-md-6">
            <label for="total_price" class="form-label">ราคารวม</label>
            <input id="total_price" type="number" class="form-control @error('total_price') is-invalid @enderror"
                name="total_price" required placeholder="ชื่อเรียกจำนวนนับวัสดุ" min="1"
                autocomplete="total_price">

            @error('total_price')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>
        <div class="mb-3 col-md-6">
            <label for="name_durableArticles_count" class="form-label">อายุการใช้
                /ปี</label>
            <input id="service_life-buy" type="text" class=" form-control " name="service_life" placeholder="5"
                required autocomplete="service_life">
        </div>
        <div class="mb-3 col-md-6">
            <label for="warranty_period" class="form-label">ระยะเวลาประกัน</label>

            <div class="d-flex">
                <input class="form-control me-2 warranty_period_start" type="text" name="warranty_period_start"
                    placeholder="dd-mm-yyyy">
                <input class="form-control warranty_period_end" type="text" name="warranty_period_end"
                    placeholder="dd-mm-yyyy">
            </div>

            @error('warranty_period')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>

        @php
            $dataStorage = DB::table('storage_locations')->get();

        @endphp
        <div class="mb-3 col-md-6">
            <label for="code_material_storage" class="form-label">ที่เก็บครุภัณฑ์</label>
            <select class="form-select" aria-label="Default select example" id="code_material_storage"
                name="code_material_storage disabled" required>
                <option selected disabled>ที่เก็บครุภัณฑ์</option>

                @foreach ($dataStorage as $storage)
                    <option value="{{ $storage->id }}">{{ $storage->building_name }}
                        {{ $storage->floor }} {{ $storage->room_name }}</option>
                @endforeach
            </select>
        </div>

    </div>
    <div class="mt-2">
        <button type="submit" class="btn btn-primary me-2">บักทึก</button>
    </div>
</form>
