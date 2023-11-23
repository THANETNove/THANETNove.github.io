$(document).ready(function () {
    $("#provinces").change(function () {
        // คลิก จังหวัด หา แขวง/อำเภอ
        var selectedProvinceId = $(this).val();
        // ตรวจสอบว่าเลือก "จังหวัด" ให้ค่าไม่ใช่ค่าเริ่มต้น
        if (selectedProvinceId !== "0") {
            // ใช้ Ajax เรียกเส้นทางใน Laravel เพื่อดึงข้อมูลแขวง/อำเภอ

            $.ajax({
                url: "/districts/" + selectedProvinceId,
                type: "GET",

                success: function (res) {
                    // อัปเดตตัวเลือก "แขวง/อำเภอ"
                    var districtsSelect = $("#districts");
                    districtsSelect.find("option").remove();
                    districtsSelect.append(
                        $("<option selected disabled>แขวง/อำเภอ</option>")
                    );

                    $.each(res, function (index, district) {
                        districtsSelect.append(
                            $("<option>", {
                                value: district.id,
                                text: district.name_th,
                            })
                        );
                    });
                },
                error: function (xhr, status, error) {
                    console.error(error);
                },
            });
        }
    });

    // คลิก แขวง/อำเภอ  หา  "เขต/ตำบล
    $("#districts").change(function () {
        var selectedDistrictId = $(this).val();

        console.log("selectedDistrictId", selectedDistrictId);
        // ตรวจสอบว่าเลือก "แขวง/อำเภอ" ให้ค่าไม่ใช่ค่าเริ่มต้น
        if (selectedDistrictId !== "0") {
            $.ajax({
                url: "/subdistrict/" + selectedDistrictId,
                type: "GET",
                success: function (res) {
                    // อัปเดตตัวเลือก "เขต/ตำบล"
                    var amphuresSelect = $("#subdistrict");
                    amphuresSelect.find("option").remove();
                    amphuresSelect.append(
                        $("<option selected disabled>เขต/ตำบล</option>")
                    );

                    $.each(res, function (index, data) {
                        amphuresSelect.append(
                            $("<option>", {
                                value: data.id,
                                text: data.name_th,
                            })
                        );
                        if (data.zip_code) {
                            document.getElementById("zip_code").value =
                                data.zip_code;
                        }
                    });
                },
                error: function (xhr, status, error) {
                    console.error(error);
                },
            });
        }
    });
});

// คลิก แขวง/อำเภอ  หา  "เขต/ตำบล
$("#code-requisition").change(function () {
    var selectedRequisition = $(this).val();

    if (selectedRequisition !== "0") {
        $.ajax({
            url: "selected-requisition/" + selectedRequisition,
            type: "GET",
            success: function (res) {
                // อัปเดตตัวเลือก "เขต/ตำบล"
                $.each(res, function (index, data) {
                    document.getElementById("remaining-amount").value =
                        data.remaining_amount;
                    document.getElementById("name-material-count").value =
                        data.name_material_count;
                    document.getElementById("material-name").value =
                        data.material_name;
                    document.getElementById("material-id").value = data.id;

                    var remainingAmountInput =
                        document.getElementById("amount_withdraw");

                    if (remainingAmountInput && !isNaN(data.remaining_amount)) {
                        remainingAmountInput.setAttribute(
                            "max",
                            data.remaining_amount
                        );
                    }

                    if (data.remaining_amount == 0) {
                        document.getElementById("out-stock").textContent =
                            " วัสดุหมดเเล้ว ไม่สามารถเบิกได้";
                    } else {
                        document.getElementById("out-stock").textContent = "";
                    }
                    console.log("data", data.remaining_amount);
                });
            },
            error: function (xhr, status, error) {
                console.error(error);
            },
        });
    }
});

/// ดึง URL ปัจจุบันหลังจาก /
const setActiveClass = (mainItemId, subItemId) => {
    const menuItem = document.getElementById(mainItemId);
    menuItem.classList.add("active", "open");
    const subItem = document.getElementById(subItemId);
    subItem.classList.add("active");
};

const targetUrls = window.location.pathname.split("/")[1];

// สมัครสมาชิก
if (
    targetUrls === "personnel-index" ||
    targetUrls === "personnel-edit" ||
    targetUrls === "personnel-show"
) {
    setActiveClass("personnel", "personnel-index");
}
if (targetUrls === "personnel-create") {
    setActiveClass("personnel", "personnel-create");
}
// สถานที่จัดเก็บ
if (targetUrls === "storage-index" || targetUrls === "storage-edit") {
    setActiveClass("storage", "storage-index");
}
if (targetUrls === "storage-create") {
    setActiveClass("storage", "storage-create");
}
// ระบบวัสดุ
if (targetUrls === "material-index" || targetUrls === "material-edit") {
    setActiveClass("material", "material-index");
}
if (targetUrls === "material-create") {
    setActiveClass("material", "material-create");
}

// ข้อมูลครุภัณฑ์
if (
    targetUrls === "durable-articles-index" ||
    targetUrls === "durable-articles-edit"
) {
    setActiveClass("durable-articles", "durable-articles-index");
}
if (targetUrls === "durable-articles-create") {
    setActiveClass("durable-articles", "durable-articles-create");
}
// ระบบจัดซื้อ
if (targetUrls === "buy-index" || targetUrls === "buy-edit") {
    setActiveClass("buy", "buy-index");
}
if (targetUrls === "buy-create") {
    setActiveClass("buy", "buy-create");
}
// ระบบจัดซื้อ
if (
    targetUrls === "material-requisition-index" ||
    targetUrls === "material-requisition-edit"
) {
    setActiveClass("material-requisition", "material-requisition-index");
}
if (targetUrls === "material-requisition-create") {
    setActiveClass("material-requisition", "material-requisition-create");
}
console.log("targetUrls", targetUrls);
