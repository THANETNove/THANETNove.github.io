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

// หา วัสดุ

/* $("#code_requisition").on("input", function () {
    var selectedRequisition = $(this).val();
    console.log("selectedRequisition", selectedRequisition);

    if (selectedRequisition.trim() !== "") {
        $.ajax({
            url: "selected-requisition/" + selectedRequisition,
            type: "GET",
            success: function (res) {
                console.log("res", res);

                if (res.length > 0) {
                    var data = res[0]; // Assuming you're interested in the first result

                    displayPopupWithData(res);
                    document.getElementById("remaining-amount").value =
                        data.remaining_amount;
                    document.getElementById("name-material-count").value =
                        data.name_material_count;
                    document.getElementById("material-name").value =
                        data.material_name;
                    document.getElementById("material-id").value = data.id;

                    if (data.remaining_amount == 0) {
                        document.getElementById("out-stock").textContent =
                            " วัสดุหมดแล้ว ไม่สามารถเบิกได้";
                    } else {
                        document.getElementById("out-stock").textContent = "";
                    }
                    console.log("data", data.remaining_amount);
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            },
        });
    } else {
        document.getElementById("material-name").value = null;
        hidePopup();
    }
}); */

function displayPopupWithData(data) {
    console.log("data", data);
    var popupContent = "<ul>";
    var popupContentName = "<ul>";
    // Assuming data is an array of objects with some property like 'name'
    if (data && data) {
        // Check if 'data.name' is defined before using it
        if (data.length == 1) {
            hidePopup();
            document.getElementById("material_id").value = data["0"].id;
            document.getElementById("material-name").value =
                data["0"].material_name;
            var remainingAmountInput =
                document.getElementById("amount_withdraw");

            if (remainingAmountInput && !isNaN(data["0"].remaining_amount)) {
                remainingAmountInput.setAttribute(
                    "max",
                    data[0].remaining_amount
                );
            }
            document.getElementById(
                "code_requisition"
            ).value = `${data["0"].group_class}-${data["0"].type_durableArticles}-${data["0"].description}`;
        } else {
            data.forEach(function (item) {
                popupContent +=
                    "<li>" +
                    item.group_class +
                    "-" +
                    item.type_durableArticles +
                    "-" +
                    item.description +
                    "</li>";
                popupContentName += "<li>" + item.material_name + "</li>";
            });
        }
    } else {
        popupContent += "<li>Data not available</li>";
        popupContentName += "<li>Data not available</li>";
    }

    popupContent += "</ul>";
    popupContentName += "</ul>";

    var popup = document.getElementById("popup");
    popup.innerHTML = popupContent;
    popup.style.display = "block";

    var popupName = document.getElementById("popup-name");
    popupName.innerHTML = popupContentName;
    popupName.style.display = "block";

    var popupBtn = document.getElementById("btn-danger");
    popupBtn.innerHTML = "ลบ";
    popupBtn.style.display = "block";
}

$("#btn-danger").click(function () {
    document.getElementById("code_requisition").value = "";
    document.getElementById("material-name").value = "";
    document.getElementById("material_id").value = "";
    document.getElementById("remaining-amount").value = "";
    document.getElementById("name-material-count").value = "";
    var popupBtn = document.getElementById("btn-danger");
    popupBtn.style.display = "none";
    // Add your additional click event handling logic
});

function hidePopup() {
    var popup = document.getElementById("popup");
    popup.style.display = "none";
    var popupName = document.getElementById("popup-name");
    popupName.style.display = "none";
    var popupBtn = document.getElementById("btn-danger");
    popupBtn.style.display = "none";
}

// หา ครุภัณฑ์

/* $("#code_durable_articles").on("input", function () {
    var selectedRequisition = $(this).val();
    console.log("selectedRequisition", selectedRequisition);

    if (selectedRequisition.trim() !== "") {
        $.ajax({
            url: "selected-durable-requisition/" + selectedRequisition,
            type: "GET",
            success: function (res) {
                console.log("res", res);

                if (res.length > 0) {
                    var data = res[0]; // Assuming you're interested in the first result
                    displayPopupWithDataDurable(res);
                    if (data.remaining_amount == 0) {
                        document.getElementById("out-stock").textContent =
                            " วัสดุหมดแล้ว ไม่สามารถเบิกได้";
                    } else {
                        document.getElementById("out-stock").textContent = "";
                    }
                    console.log("data", data.remaining_amount);
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            },
        });
    } else {
        document.getElementById("material-name").value = null;
        hidePopup();
    }
}); */

function displayPopupWithDataDurable(data) {
    console.log("data", data);
    var popupContent = "<ul>";
    var popupContentName = "<ul>";
    // Assuming data is an array of objects with some property like 'name'
    if (data && data) {
        // Check if 'data.name' is defined before using it
        if (data.length == 1) {
            hidePopupDurable();
            document.getElementById("durable_articles_id").value = data["0"].id;
            document.getElementById("durable_articles-name").value =
                data["0"].durableArticles_name;
            document.getElementById("remaining-amount").value =
                data["0"].remaining_amount;
            document.getElementById("name-durable_articles-count").value =
                data["0"].name_durableArticles_count;
            var remainingAmountInput =
                document.getElementById("amount_withdraw");

            if (remainingAmountInput && !isNaN(data["0"].remaining_amount)) {
                remainingAmountInput.setAttribute(
                    "max",
                    data[0].remaining_amount
                );
            }
            document.getElementById(
                "code_durable_articles"
            ).value = `${data["0"].group_class}-${data["0"].type_durableArticles}-${data["0"].description}`;
        } else {
            data.forEach(function (item) {
                popupContent +=
                    "<li>" +
                    item.group_class +
                    "-" +
                    item.type_durableArticles +
                    "-" +
                    item.description +
                    "</li>";
                popupContentName +=
                    "<li>" + item.durableArticles_name + "</li>";
            });
        }
    } else {
        popupContent += "<li>Data not available</li>";
        popupContentName += "<li>Data not available</li>";
    }

    popupContent += "</ul>";
    popupContentName += "</ul>";

    var popup = document.getElementById("popup-code");
    popup.innerHTML = popupContent;
    popup.style.display = "block";

    var popupName = document.getElementById("popup-durable");
    popupName.innerHTML = popupContentName;
    popupName.style.display = "block";

    var popupBtn = document.getElementById("btn-danger-durable");
    popupBtn.innerHTML = "ลบ";
    popupBtn.style.display = "block";
}

$("#btn-danger-durable").click(function () {
    document.getElementById("durable_articles_id").value = "";
    document.getElementById("durable_articles-name").value = "";
    document.getElementById("code_durable_articles").value = "";
    document.getElementById("remaining-amount").value = "";
    document.getElementById("name-durable_articles-count").value = "";
    var popupBtn = document.getElementById("btn-danger-durable");
    popupBtn.style.display = "none";
    // Add your additional click event handling logic
});

function hidePopupDurable() {
    var popup = document.getElementById("popup-code");
    popup.style.display = "none";
    var popupName = document.getElementById("popup-durable");
    popupName.style.display = "none";
    /*  var popupBtn = document.getElementById("btn-danger");
    popupBtn.style.display = "none"; */
}

/// ดึง URL ปัจจุบันหลังจาก /
const setActiveClass = (mainItemId, subItemId) => {
    const menuItem = document.getElementById(mainItemId);
    menuItem.classList.add("active", "open");
    const subItem = document.getElementById(subItemId);
    subItem.classList.add("active");
};

const targetUrls = window.location.pathname.split("/")[1];

// เเผนก
if (targetUrls === "department-index" || targetUrls === "department-edit") {
    setActiveClass("department", "department-index");
}
if (targetUrls === "department-create") {
    setActiveClass("department", "department-create");
}

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
// หมวดหมู่วัสดุเเละครุภัณฑ์
if (targetUrls === "category-index" || targetUrls === "category-edit") {
    setActiveClass("category", "category-index");
}
if (targetUrls === "category-create") {
    setActiveClass("category", "category-create");
}
//หมวดหมู่ เพิ่ม ชื่อครุภัณฑ์
if (targetUrls === "typeCategory-index") {
    setActiveClass("typeCategory", "typeCategory-index");
}
if (targetUrls === "typeCategory-create") {
    setActiveClass("typeCategory", "typeCategory-create");
}
// ระบบเบิกวัสดุ
if (
    targetUrls === "material-requisition-index" ||
    targetUrls === "material-requisition-edit"
) {
    setActiveClass("material-requisition", "material-requisition-index");
}
if (targetUrls === "material-requisition-create") {
    setActiveClass("material-requisition", "material-requisition-create");
}
//ครุภัณฑ์
if (
    targetUrls === "durable-articles-requisition-index" ||
    targetUrls === "durable-articles-requisition-edit" ||
    targetUrls === "durable-articles-requisition-show"
) {
    setActiveClass(
        "durable-articles-requisition",
        "durable-articles-requisition-index"
    );
}
if (targetUrls === "durable-articles-requisition-create") {
    setActiveClass(
        "durable-articles-requisition",
        "durable-articles-requisition-create"
    );
}
if (targetUrls === "durable-articles-requisition-create-lend") {
    setActiveClass(
        "durable-articles-requisition",
        "durable-articles-requisition-create-lend"
    );
}

//ครุภัณฑ์ชำรุด
if (
    targetUrls === "durable-articles-damaged-index" ||
    targetUrls === "durable-articles-damaged-edit" ||
    targetUrls === "durable-articles-damaged-show"
) {
    setActiveClass(
        "durable-articles-damaged",
        "durable-articles-damaged-index"
    );
}
if (targetUrls === "durable-articles-damaged-create") {
    setActiveClass(
        "durable-articles-damaged",
        "durable-articles-damaged-create"
    );
}
//ครุภัณฑ์ซ่อม
if (
    targetUrls === "durable-articles-repair-index" ||
    targetUrls === "durable-articles-repair-edit"
) {
    setActiveClass("durable-articles-repair", "durable-articles-repair-index");
}
if (targetUrls === "durable-articles-repair-create") {
    setActiveClass("durable-articles-repair", "durable-articles-repair-create");
}

//เเทงจำหน่ายครุภัณฑ์
if (
    targetUrls === "bet-distribution-index" ||
    targetUrls === "bet-distribution-edit"
) {
    setActiveClass("bet-distribution", "bet-distribution-index");
}
if (targetUrls === "bet-distribution-create") {
    setActiveClass("bet-distribution", "bet-distribution-create");
}

//เเทงจำหน่ายครุภัณฑ์

if (targetUrls === "calculator-create") {
    setActiveClass("calculator", "calculator-create");
}
//อนุมัติเเทงจำหน่ายครุภัณฑ์

if (targetUrls === "bet-distribution-indexApproval") {
    setActiveClass("index-approval", "bet-distribution-indexApproval");
}
//คึนครุภัณฑ์

if (targetUrls === "return-item-index") {
    setActiveClass("return-item", "return-item-index");
}
if (targetUrls === "return-item-show") {
    setActiveClass("return-item", "return-item-index");
}
//รายงาน

if (targetUrls === "report-material") {
    setActiveClass("report-ex", "report-material");
}
if (targetUrls === "personnel-export") {
    setActiveClass("report-ex", "personnel-export");
}
if (targetUrls === "storage-export") {
    setActiveClass("report-ex", "storage-export");
}
if (targetUrls === "report-durable") {
    setActiveClass("report-ex", "report-durable");
}

console.log("targetUrls", targetUrls);

//อนุมัติ
if (targetUrls === "approval-update") {
    setActiveClass("approval", "approval-update");
}
if (targetUrls === "buy-shop") {
    setActiveClass("buy-shop", "buy-shop-index");
}
console.log("targetUrls", targetUrls);

function myFunction(selectedValue) {
    // ทำอะไรก็ตามที่คุณต้องการเมื่อมีการเปลี่ยนแปลงค่าใน <select>
    // เช่น เรียกใช้ AJAX เพื่อโหลดข้อมูลเพิ่มเติม, ส่งค่าไปที่ฟอร์ม, หรืออื่น ๆ

    document.getElementById("myForm").submit();

    // ทำต่อไปตามความต้องการ
}

var globalRes; // สร้างตัวแปร global เพื่อเก็บค่า res
var globalCount;
var globalResType; // สร้างตัวแปร global เพื่อเก็บค่า res
var globalStorage; // ที่เก็บของ

function getCategories(selectedValue) {
    globalResType = selectedValue;
    if (selectedValue == 1) {
        document.getElementById("id-group").innerText = "id วัสดุ";
        $("#group_id").empty();
        $.ajax({
            url: "get-categories/" + selectedValue,
            type: "GET",
            success: function (res) {
                var groupSelect = $("#group_id");
                groupSelect.empty();
                groupSelect.append(
                    $("<option>", {
                        value: "",
                        text: "เลือกหมวดหมู่",
                        selected: true,
                        disabled: true, // or use .prop('selected', true)
                    })
                );
                $.each(res, function (index, data) {
                    groupSelect.append(
                        $("<option>", {
                            value: data.id,
                            text: data.category_name,
                        })
                    );
                });
            },
            error: function (xhr, status, error) {
                console.error(error);
            },
        });
    } else {
        document.getElementById("id-group").innerText = "id ครุภัณฑ์";
        $("#group_id").empty();
        $.ajax({
            url: "get-categories/" + selectedValue,
            type: "GET",
            success: function (res) {
                var groupSelect = $("#group_id");

                // Clear existing options (optional, depending on your use case)
                groupSelect.empty();

                // Loop through each element in the 'res' array
                groupSelect.append(
                    $("<option>", {
                        value: "",
                        text: "เลือกหมวดหมู่",
                        selected: true,
                        disabled: true, // or use .prop('selected', true)
                    })
                );

                $.each(res, function (index, data) {
                    groupSelect.append(
                        $("<option>", {
                            value: data.id,
                            text: data.category_name,
                        })
                    );
                });
            },
            error: function (xhr, status, error) {
                console.error(error);
            },
        });
    }
}

function getGroup(selectedValue) {
    $.ajax({
        url: "get-categoriesData/" + selectedValue,
        type: "GET",
        success: function (res) {
            console.log("res 555", res);

            globalRes = res[0];
            globalCount = res[1];
            globalStorage = res[2];
            var groupSelect = $("#buy_name");
            // Clear existing options (optional, depending on your use case)
            groupSelect.empty();

            // Loop through each element in the 'res' array
            groupSelect.append(
                $("<option>", {
                    value: "",
                    text:
                        globalResType == 1
                            ? "เลือกชื่อวัสดุ"
                            : "เลือกชื่อครุภัณฑ์",
                    selected: true,
                    disabled: true, // or use .prop('selected', true)
                })
            );

            $.each(res[0], function (index, data) {
                groupSelect.append(
                    $("<option>", {
                        value: data.id,
                        text:
                            globalResType == 1
                                ? data.material_name
                                : data.durableArticles_name,
                    })
                );
            });
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
}

$("#buy_name").on("change", function () {
    var selectedValue = $(this).val(); // รับค่าที่ถูกเลือก

    // ใช้ globalRes ที่เก็บค่า res จาก getGroup

    var foundItem = globalRes.find(function (item) {
        return item.id == selectedValue;
    });
    var foundStorage = globalStorage.find(function (item) {
        return item.code_storage == foundItem.code_material_storage;
    });

    if (foundItem) {
        $("#categories_id2").val(foundItem.code_material);

        var groupSelect = $("#code_material_storage");

        // Clear existing options (optional, depending on your use case)
        groupSelect.empty();

        // Loop through each element in the 'res' array
        groupSelect.append(
            $("<option>", {
                value: "",
                text: globalResType == 1 ? "ที่เก็บวัสดุ" : "ที่เก็บครุภัณฑ์",
                selected: true,
                disabled: true, // or use .prop('selected', true)
            })
        );

        $.each(globalStorage, function (index, data) {
            groupSelect.append(
                $("<option>", {
                    value: globalStorage[index].code_storage,
                    text:
                        globalStorage[index].building_name +
                        " " +
                        globalStorage[index].floor +
                        " " +
                        globalStorage[index].room_name,
                    selected:
                        foundStorage.code_storage ==
                            globalStorage[index].code_storage && true,
                })
            );
        });

        if (globalResType == 2) {
            $("#code-id").val(foundItem.code_DurableArticles);
            $("#categories_id").val(
                foundItem.category_code +
                    "-" +
                    foundItem.type_code +
                    "-" +
                    foundItem.description +
                    "-" +
                    foundItem.group_count
            );
            $("#service_life-buy").val(foundItem.service_life);
        } else {
            $("#code-id").val(foundItem.id);
            $("#counting_unit").val(foundItem.name_material_count);
        }
    }
});

$(".date").datepicker({
    dateFormat: "dd-mm-yy",
    changeMonth: true,
    changeYear: true,
    yearRange: "c-100:c+10", // ปีปัจจุบัน - 100 ถึง ปีปัจจุบัน + 10
    dayNames: [
        "อาทิตย์",
        "จันทร์",
        "อังคาร",
        "พุธ",
        "พฤหัสบดี",
        "ศุกร์",
        "เสาร์",
    ],
    dayNamesMin: ["อา.", "จ.", "อ.", "พ.", "พฤ.", "ศ.", "ส."],
    monthNames: [
        "มกราคม",
        "กุมภาพันธ์",
        "มีนาคม",
        "เมษายน",
        "พฤษภาคม",
        "มิถุนายน",
        "กรกฎาคม",
        "สิงหาคม",
        "กันยายน",
        "ตุลาคม",
        "พฤศจิกายน",
        "ธันวาคม",
    ],
    monthNamesShort: [
        "ม.ค.",
        "ก.พ.",
        "มี.ค.",
        "เม.ย.",
        "พ.ค.",
        "มิ.ย.",
        "ก.ค.",
        "ส.ค.",
        "ก.ย.",
        "ต.ค.",
        "พ.ย.",
        "ธ.ค.",
    ],
    onSelect: function (dateText, inst) {
        // คำสั่งที่จะทำเมื่อเลือกวันที่
    },
});

var dateValue = $("#warranty_period").val();

console.log("dateValue", dateValue);

// เมื่อเอกสารโหลดเสร็จ
$(".dateMin").datepicker({
    dateFormat: "dd-mm-yy",
    changeMonth: true,
    changeYear: true,
    yearRange: "c-100:c+10",
    dayNames: [
        "อาทิตย์",
        "จันทร์",
        "อังคาร",
        "พุธ",
        "พฤหัสบดี",
        "ศุกร์",
        "เสาร์",
    ],
    dayNamesMin: ["อา.", "จ.", "อ.", "พ.", "พฤ.", "ศ.", "ส."],
    monthNames: [
        "มกราคม",
        "กุมภาพันธ์",
        "มีนาคม",
        "เมษายน",
        "พฤษภาคม",
        "มิถุนายน",
        "กรกฎาคม",
        "สิงหาคม",
        "กันยายน",
        "ตุลาคม",
        "พฤศจิกายน",
        "ธันวาคม",
    ],
    monthNamesShort: [
        "ม.ค.",
        "ก.พ.",
        "มี.ค.",
        "เม.ย.",
        "พ.ค.",
        "มิ.ย.",
        "ก.ค.",
        "ส.ค.",
        "ก.ย.",
        "ต.ค.",
        "พ.ย.",
        "ธ.ค.",
    ],
    minDate: dateValue,
});

var dateFormat = "yy-mm-dd";

var from = $("#start_date").datepicker({
    dateFormat: dateFormat,
    changeMonth: true,
    changeYear: true,
    yearRange: "c-100:c+10",
    dayNames: [
        "อาทิตย์",
        "จันทร์",
        "อังคาร",
        "พุธ",
        "พฤหัสบดี",
        "ศุกร์",
        "เสาร์",
    ],
    dayNamesMin: ["อา.", "จ.", "อ.", "พ.", "พฤ.", "ศ.", "ส."],
    monthNames: [
        "มกราคม",
        "กุมภาพันธ์",
        "มีนาคม",
        "เมษายน",
        "พฤษภาคม",
        "มิถุนายน",
        "กรกฎาคม",
        "สิงหาคม",
        "กันยายน",
        "ตุลาคม",
        "พฤศจิกายน",
        "ธันวาคม",
    ],
    monthNamesShort: [
        "ม.ค.",
        "ก.พ.",
        "มี.ค.",
        "เม.ย.",
        "พ.ค.",
        "มิ.ย.",
        "ก.ค.",
        "ส.ค.",
        "ก.ย.",
        "ต.ค.",
        "พ.ย.",
        "ธ.ค.",
    ],
});

$("#end_date").datepicker({
    dateFormat: dateFormat,
    changeMonth: true,
    changeYear: true,
    numberOfMonths: 1,
    dayNames: [
        "อาทิตย์",
        "จันทร์",
        "อังคาร",
        "พุธ",
        "พฤหัสบดี",
        "ศุกร์",
        "เสาร์",
    ],
    dayNamesMin: ["อา.", "จ.", "อ.", "พ.", "พฤ.", "ศ.", "ส."],
    monthNames: [
        "มกราคม",
        "กุมภาพันธ์",
        "มีนาคม",
        "เมษายน",
        "พฤษภาคม",
        "มิถุนายน",
        "กรกฎาคม",
        "สิงหาคม",
        "กันยายน",
        "ตุลาคม",
        "พฤศจิกายน",
        "ธันวาคม",
    ],
    monthNamesShort: [
        "ม.ค.",
        "ก.พ.",
        "มี.ค.",
        "เม.ย.",
        "พ.ค.",
        "มิ.ย.",
        "ก.ค.",
        "ส.ค.",
        "ก.ย.",
        "ต.ค.",
        "พ.ย.",
        "ธ.ค.",
    ],
    beforeShowDay: function (date) {
        var startDate = $("#start_date").val();
        if (startDate) {
            var startDateObj = new Date(startDate);
            var currentDate = new Date(date);
            if (currentDate <= startDateObj) {
                return [false, ""];
            }
        }
        return [true, ""];
    },
});

// script.js

//วัสดุ

var materialRes;
function groupMaterial(selectedValue) {
    $.ajax({
        url: "get-material/" + selectedValue,
        type: "GET",
        success: function (res) {
            materialRes = res;
            console.log("res", res);
            var groupName = $("#material-name");

            // Clear existing options (optional, depending on your use case)
            groupName.empty();

            // Loop through each element in the 'res' array
            groupName.append(
                $("<option>", {
                    value: "",
                    text: "เลือกวัสดุ",
                    selected: true,
                    disabled: true, // or use .prop('selected', true)
                })
            );

            $.each(res, function (index, data) {
                groupName.append(
                    $("<option>", {
                        value: data.id,
                        text: data.material_name,
                    })
                );
            });
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
}

$("#material-name").on("change", function () {
    var selectedValue = $(this).val(); // รับค่าที่ถูกเลือก

    console.log("materialRes", materialRes);

    // ใช้ globalRes ที่เก็บค่า res จาก getGroup
    var foundItem = materialRes.find(function (item) {
        return item.id == selectedValue;
    });
    if (foundItem) {
        if (
            foundItem.remaining_amount == 0 ||
            foundItem.remaining_amount == null
        ) {
            document.getElementById("out-stock").textContent =
                "ไม่สามารถลงทะเบียนได้";
            var popup = document.getElementById("submit");
            popup.style.display = "none";
        } else {
            document.getElementById("out-stock").textContent = "";
            var popup = document.getElementById("submit");
            popup.style.display = "block";
        }
        document
            .getElementById("amount_withdraw")
            .setAttribute("max", foundItem.remaining_amount);
        $("#code_requisition").val(foundItem.code_material);
        $("#remaining-amount").val(foundItem.remaining_amount);
        $("#name-material-count").val(foundItem.name_material_count);
    }
});

//เบิกครุภัณฑ์-ครุภัณฑ์ที่ชำรุด

var durableArticlesRes;

function groupDurableArticles(selectedValue) {
    $.ajax({
        url: "get-typeCategories/" + selectedValue,
        type: "GET",
        success: function (res) {
            durableArticlesRes = res;
            console.log("res", res);
            var groupName = $("#durable_articles_name");
            var groupName2 = $("#durable_articles_name2");

            // Clear existing options (optional, depending on your use case)
            groupName.empty();
            groupName2.empty();

            // Loop through each element in the 'res' array
            groupName.append(
                $("<option>", {
                    value: "",
                    text: "เลือกครุภัณฑ์",
                    selected: true,
                    disabled: true, // or use .prop('selected', true)
                })
            );
            groupName2.append(
                $("<option>", {
                    value: "",
                    text: "เลือกครุภัณฑ์",
                    selected: true,
                    disabled: true, // or use .prop('selected', true)
                })
            );

            $.each(res, function (index, data) {
                groupName.append(
                    $("<option>", {
                        value: data.id,
                        text: data.type_name,
                    })
                );
            });
            $.each(res, function (index, data) {
                groupName2.append(
                    $("<option>", {
                        value: data.id,
                        text: data.type_name,
                    })
                );
            });
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
}

var details_name;

$("#durable_articles_name").on("change", function () {
    var selectedValue = $(this).val(); // รับค่าที่ถูกเลือก

    // ใช้ globalRes ที่เก็บค่า res จาก getGroup
    $.ajax({
        url: "get-articlesRes/" + selectedValue,
        type: "GET",
        success: function (res) {
            details_name = res;

            var groupName = $("#details-name");

            // Clear existing options (optional, depending on your use case)
            groupName.empty();

            // Loop through each element in the 'res' array
            groupName.append(
                $("<option>", {
                    value: "",
                    text: "รายละเอียดรุภัณฑ์",
                    selected: true,
                    disabled: true, // or use .prop('selected', true)
                })
            );

            $.each(res, function (index, data) {
                groupName.append(
                    $("<option>", {
                        value: data.id,
                        text: data.durableArticles_name,
                    })
                );
            });
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
});

/* $("#durable_articles_name2").on("change", function () {
    var selectedValue = $(this).val(); // รับค่าที่ถูกเลือก

    // ใช้ globalRes ที่เก็บค่า res จาก getGroup
    $.ajax({
        url: "get-articlesRes-damaged/" + selectedValue,
        type: "GET",
        success: function (res) {
            details_name = res;

            var groupName = $("#details-name");
            var groupName2 = $("#details-name2");

            // Clear existing options (optional, depending on your use case)
            groupName.empty();
            groupName2.empty();

            // Loop through each element in the 'res' array
            groupName.append(
                $("<option>", {
                    value: "",
                    text: "รายละเอียดรุภัณฑ์",
                    selected: true,
                    disabled: true, // or use .prop('selected', true)
                })
            );
            groupName2.append(
                $("<option>", {
                    value: "",
                    text: "รายละเอียดรุภัณฑ์",
                    selected: true,
                    disabled: true, // or use .prop('selected', true)
                })
            );

            $.each(res, function (index, data) {
                groupName.append(
                    $("<option>", {
                        value: data.id,
                        text: data.durableArticles_name,
                    })
                );
            });
            $.each(res, function (index, data) {
                groupName2.append(
                    $("<option>", {
                        value: data.id,
                        text:
                            data.durableArticles_name + " " + data.group_count,
                    })
                );
            });
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
}); */

$("#details-name").on("change", function () {
    const selectedValue = $(this).val(); // รับค่าที่ถูกเลือก
    var foundItem = details_name.find(function (item) {
        return item.id == selectedValue;
    });

    if (foundItem) {
        if (
            foundItem.remaining_amount == 0 ||
            foundItem.remaining_amount == null
        ) {
            document.getElementById("out-stock").textContent =
                "ไม่สามารถลงทะเบียนได้";
            var popup = document.getElementById("submit");
            popup.style.display = "none";
        } else {
            document.getElementById("out-stock").textContent = "";
            var popup = document.getElementById("submit");
            popup.style.display = "block";
        }

        document
            .getElementById("amount_withdraw")
            .setAttribute("max", foundItem.remainingAmountCount);
        $("#code_durable_articles").val(
            foundItem.category_code +
                "-" +
                foundItem.type_code +
                "-" +
                foundItem.description
        );
        $("#remaining-amount").val(foundItem.remainingAmountCount);
        $("#name-durable_articles-count").val(
            foundItem.name_durableArticles_count
        );
        $("#durable_articles_id").val(foundItem.code_DurableArticles);
    }
});
$("#details-name2").on("change", function () {
    const selectedValue = $(this).val(); // รับค่าที่ถูกเลือก
    var foundItem = details_name.find(function (item) {
        return item.id == selectedValue;
    });

    if (foundItem) {
        if (
            foundItem.remaining_amount == 0 ||
            foundItem.remaining_amount == null
        ) {
            document.getElementById("out-stock").textContent =
                "ไม่สามารถลงทะเบียนได้";
            var popup = document.getElementById("submit");
            popup.style.display = "none";
        } else {
            document.getElementById("out-stock").textContent = "";
            var popup = document.getElementById("submit");
            popup.style.display = "block";
        }

        document
            .getElementById("amount_withdraw")
            .setAttribute("max", foundItem.remaining_amount);
        $("#code_durable_articles").val(
            foundItem.category_code +
                "-" +
                foundItem.type_code +
                "-" +
                foundItem.description +
                "-" +
                foundItem.group_count
        );
        $("#remaining-amount").val(foundItem.remaining_amount);
        $("#name-durable_articles-count").val(
            foundItem.name_durableArticles_count
        );
        $("#durable_articles_id").val(foundItem.id);
    }
});

//ระบบซ่อม  //ระบบเเทงจำหน่าย

var durableArticlesRepairRes;
function groupDurableArticlesRepair(selectedValue) {
    $.ajax({
        url: "get-articlesRepair/" + selectedValue,
        type: "GET",
        success: function (res) {
            durableArticlesRepairRes = res;
            console.log("res", res);
            var groupName = $("#durable_articles_repair_name");
            var groupName2 = $("#durable_articles_repair_name2");

            // Clear existing options (optional, depending on your use case)
            groupName.empty();
            groupName2.empty();

            // Loop through each element in the 'res' array
            groupName.append(
                $("<option>", {
                    value: "",
                    text: "เลือกครุภัณฑ์",
                    selected: true,
                    disabled: true, // or use .prop('selected', true)
                })
            );
            groupName2.append(
                $("<option>", {
                    value: "",
                    text: "เลือกครุภัณฑ์",
                    selected: true,
                    disabled: true, // or use .prop('selected', true)
                })
            );

            $.each(res, function (index, data) {
                groupName.append(
                    $("<option>", {
                        value: data.id,
                        text: data.type_name,
                    })
                );
            });
            $.each(res, function (index, data) {
                groupName2.append(
                    $("<option>", {
                        value: data.id,
                        text: data.type_name,
                    })
                );
            });
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
}

var detailsRepairNameRes;
$("#durable_articles_repair_name").on("change", function () {
    var selectedValue = $(this).val();

    $.ajax({
        url: "get-details_repair_name/" + selectedValue,
        type: "GET",
        success: function (res) {
            detailsRepairNameRes = res;
            console.log("res", res);
            var groupName = $("#details_repair_name");

            // Clear existing options (optional, depending on your use case)
            groupName.empty();

            // Loop through each element in the 'res' array
            groupName.append(
                $("<option>", {
                    value: "",
                    text: "เลือกครุภัณฑ์",
                    selected: true,
                    disabled: true, // or use .prop('selected', true)
                })
            );

            $.each(res, function (index, data) {
                groupName.append(
                    $("<option>", {
                        value: data.durable_articles_id,
                        text:
                            data.durableArticles_name + " " + data.group_count,
                    })
                );
            });
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
});
$("#durable_articles_repair_name2").on("change", function () {
    var selectedValue = $(this).val();

    $.ajax({
        url: "get-details_repair_name2/" + selectedValue,
        type: "GET",
        success: function (res) {
            detailsRepairNameRes = res;
            console.log("res 555", res);
            var groupName = $("#details_repair_name");

            // Clear existing options (optional, depending on your use case)
            groupName.empty();

            // Loop through each element in the 'res' array
            groupName.append(
                $("<option>", {
                    value: "",
                    text: "เลือกครุภัณฑ์",
                    selected: true,
                    disabled: true, // or use .prop('selected', true)
                })
            );

            $.each(res, function (index, data) {
                groupName.append(
                    $("<option>", {
                        value: data.durable_articles_id,
                        text:
                            data.durableArticles_name + " " + data.group_count,
                    })
                );
            });
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
});

$("#details_repair_name").on("change", function () {
    var selectedValue = $(this).val(); // รับค่าที่ถูกเลือก
    console.log("selectedValue", selectedValue);
    // ใช้ globalRes ที่เก็บค่า res จาก getGroup
    var foundItem = detailsRepairNameRes.find(function (item) {
        return item.durable_articles_id == selectedValue;
    });
    

    if (foundItem) {
        $("#code_durable_articles").val(
            foundItem.category_code +
                "-" +
                foundItem.type_code +
                "-" +
                foundItem.description +
                "-" +
                foundItem.group_count
        );
        /*  $("#amount_withdraw").val(foundItem.amount_damaged); */
        /*  $("#name-durable_articles-count").val(
            foundItem.name_durable_articles_count
        ); */
        $("#durable_articles_id").val(foundItem.durable_articles_id);
        $("#durable_articles_name").val(foundItem.durable_articles_name);
        $("#depreciation_price").val(foundItem.depreciation_price);
    }
});

//ระบบคำนวนค่าเสื่อม

var calculateRes;
function calculateGroup(selectedValue) {
    $.ajax({
        url: "get-calculate/" + selectedValue,
        type: "GET",
        success: function (res) {
            calculateRes = res;
            console.log("res", res);
            var groupName = $("#calculate-id");

            // Clear existing options (optional, depending on your use case)
            groupName.empty();

            // Loop through each element in the 'res' array
            groupName.append(
                $("<option>", {
                    value: "",
                    text: "เลือกครุภัณฑ์",
                    selected: true,
                    disabled: true, // or use .prop('selected', true)
                })
            );

            $.each(res, function (index, data) {
                groupName.append(
                    $("<option>", {
                        value: data.id,
                        text:
                            data.durableArticles_name + " " + data.group_count,
                    })
                );
            });
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
}

$("#calculate-id").on("change", function () {
    var selectedValue = $(this).val(); // รับค่าที่ถูกเลือก

    // ใช้ globalRes ที่เก็บค่า res จาก getGroup
    var foundItem = calculateRes.find(function (item) {
        return item.id == selectedValue;
    });

    console.log("foundItem", foundItem);
    if (foundItem) {
        $("#articles_id").val(foundItem.id);
        $("#categories_id").val(
            foundItem.category_code +
                "-" +
                foundItem.type_code +
                "-" +
                foundItem.description +
                "-" +
                foundItem.group_count
        );

        $("#quantity").val(1);
        $("#counting_unit").val(foundItem.name_durableArticles_count);
        $("#price_per_piece").val(Number(foundItem.price_per).toLocaleString());

        const salvagePrice =
            foundItem.salvage_price !== null
                ? Number(foundItem.salvage_price).toLocaleString()
                : 0;
        $("#salvage_price").val(salvagePrice);

        const createdAtTimestamp = foundItem.created_at;

        // แปลง timestamp เป็น milliseconds
        const createdAtMillis = new Date(createdAtTimestamp).getTime();

        // หาวันที่ปัจจุบัน
        const currentDateMillis = new Date().getTime();

        // คำนวณอายุการใช้งาน (ปี)
        const ageInYears = Math.floor(
            (currentDateMillis - createdAtMillis) /
                (365.25 * 24 * 60 * 60 * 1000)
        );

        let ageMultiplier = foundItem.service_life; //ปี

        $("#service_life").val(Number(foundItem.service_life));
        $("#period_use").val(ageInYears + 1);

        if (foundItem.salvage_price == 0) {
            // คำนวณค่าเสื่อม (ราคา * ค่าเสื่อม/100) / ปี (กรณีที่ยังไม่ได้จำหน่าย)
            let price = (foundItem.price_per * 20) / 100 / ageMultiplier;
            let priceDepreciation = foundItem.price_per - price;
            $("#calulate-depreciation").val(priceDepreciation.toLocaleString());
        } else {
            // คำนวณค่าเสื่อม (ราคา - ราคาซาก) / ปี (กรณีที่จำหน่าย)
            let price =
                (foundItem.price_per - foundItem.salvage_price) / ageMultiplier;
            let priceDepreciation = Number(foundItem.price_per) - Number(price);

            $("#calulate-depreciation").val(priceDepreciation.toLocaleString());
        }
    }
});

//alert-destroy
$(".alert-destroy").click(function () {
    var url = $(this).attr("href");
    confirmDestroy(url);
    return false; // ป้องกันการทำงานของลิงก์ตามปกติ
});

function confirmDestroy(url) {
    var userConfirmed = window.confirm("คุณต้องการทำตามนี้หรือไม่?");

    if (userConfirmed) {
        // ผู้ใช้กด "ตกลง"
        window.location.href = url; // ทำการ redirect ไปยัง URL
    } else {
        // ผู้ใช้กด "ยกเลิก"
        console.log("ผู้ใช้กดยกเลิก");
    }
}

//category_id

$("#category_id").on("change", function () {
    var selectedValue = $(this).val(); // รับค่าที่ถูกเลือก

    const popup = document.getElementById("category_code");
    const popup2 = document.getElementById("category_code_id");

    if (selectedValue == 1) {
        popup.removeAttribute("required");
        popup2.style.display = "none";
    } else {
        popup.setAttribute("required", true);
        popup2.style.display = "block";
    }
});

if (targetUrls == "category-edit") {
    const popup_edit = document.getElementById("category_id");
    const selectedValue = popup_edit.value;

    const popup = document.getElementById("category_code");
    const popup2 = document.getElementById("category_code_id");
    if (selectedValue == 1) {
        popup.removeAttribute("required");
        popup2.style.display = "none";
    } else {
        popup.setAttribute("required", true);
        popup2.style.display = "block";
    }
}

// ระบบลงทะเบียนครุภัณฑ์ ใหม่

$("#durable-articles-group-id").on("change", function () {
    const selectedValue = $(this).val(); // รับค่าที่ถูกเลือก

    console.log("selectedValue", selectedValue);
    $.ajax({
        url: "/get-type-categories/" + selectedValue,
        type: "GET",
        success: function (res) {
            calculateRes = res;
            console.log("res", res);
            const groupName = $("#durable-articles-type-durableArticles");

            // Clear existing options (optional, depending on your use case)
            groupName.empty();

            // Loop through each element in the 'res' array
            groupName.append(
                $("<option>", {
                    value: "",
                    text: "เลือกครุภัณฑ์",
                    selected: true,
                    disabled: true, // or use .prop('selected', true)
                })
            );

            $.each(res, function (index, data) {
                groupName.append(
                    $("<option>", {
                        value: data.id,
                        text: data.type_name,
                    })
                );
            });
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
});

if (targetUrls == "durable-articles-edit") {
    const popup_edit = document.getElementById("durable-articles-group-id");
    const selectedValue = popup_edit.value;
    const popup_type = document.getElementById("type-articles");
    const typeValue = popup_type.value;
    console.log("typeValue", typeValue);
    $.ajax({
        url: "/get-type-categories/" + selectedValue,
        type: "GET",
        success: function (res) {
            calculateRes = res;
            console.log("res", res);
            const groupName = $("#durable-articles-type-durableArticles");

            // Clear existing options (optional, depending on your use case)
            groupName.empty();

            // Loop through each element in the 'res' array
            groupName.append(
                $("<option>", {
                    value: "",
                    text: "เลือกครุภัณฑ์",
                    selected: true,
                    disabled: true, // or use .prop('selected', true)
                })
            );

            $.each(res, function (index, data) {
                groupName.append(
                    $("<option>", {
                        value: data.id,
                        text: data.type_name,
                        selected: typeValue == data.id,
                    })
                );
            });
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
}
const popup2 = document.getElementById("categories-type");
popup2.style.display = "none";

const popup3 = document.getElementById("department-type");
popup3.style.display = "none";

const popup4 = document.getElementById("users-type");
popup4.style.display = "none";

var numberClick;
$("#flexRadioDefault0").on("click", function () {
    numberClick = 0;
    popup2.style.display = "none";
    popup3.style.display = "none";
    popup4.style.display = "none";
});
$("#flexRadioDefault1").on("click", function () {
    numberClick = 1;
    popup2.style.display = "none";
    popup3.style.display = "none";
    popup4.style.display = "none";
});
$("#flexRadioDefault2").on("click", function () {
    numberClick = 2;
    popup2.style.display = "none";
    popup3.style.display = "none";
    popup4.style.display = "none";
});
$("#flexRadioDefault3").on("click", function () {
    console.log("aaa");
    numberClick = 3;
    popup2.style.display = "block";
    popup3.style.display = "none";
    popup4.style.display = "none";
});

$("#flexRadioDefault4").on("click", function () {
    numberClick = 4;
    popup2.style.display = "none";
    popup3.style.display = "block";
    popup4.style.display = "none";
});

$("#flexRadioDefault5").on("click", function () {
    numberClick = 5;
    popup2.style.display = "none";
    popup3.style.display = "none";
    popup4.style.display = "block";
});
$("#flexRadioDefault6").on("click", function () {
    numberClick = 6;
    popup2.style.display = "none";
    popup3.style.display = "none";
    popup4.style.display = "none";
});
$("#flexRadioDefault7").on("click", function () {
    numberClick = 7;
    popup2.style.display = "none";
    popup3.style.display = "none";
    popup4.style.display = "none";
});
$("#flexRadioDefault8").on("click", function () {
    numberClick = 8;
    popup2.style.display = "none";
    popup3.style.display = "none";
    popup4.style.display = "none";
});
$("#flexRadioDefault9").on("click", function () {
    numberClick = 9;
    popup2.style.display = "none";
    popup3.style.display = "none";
    popup4.style.display = "none";
});

$("#exportFrom").submit(function (event) {
    if (numberClick == "3") {
        if ($("#categories_type").val() === null) {
            alert("กรุณาเลือกประเภท");
            event.preventDefault(); // ยกเลิกการ submit
        }
    }
    if (numberClick == "4") {
        if ($("#department_type").val() === null) {
            alert("กรุณาเลือกหน่วยงาน");
            event.preventDefault(); // ยกเลิกการ submit
        }
    }
    if (numberClick == "5") {
        if ($("#users_type").val() === null) {
            alert("กรุณาเลือกชื่อ");
            event.preventDefault(); // ยกเลิกการ submit
        }
    }
    // ตรวจสอบว่ามีการเลือกประเภทหรือไม่
});

// ทำการคำนวณราคารวมที่นี่

function calculateTotalPrice() {
    const quantity = document.querySelector(".quantity").value;
    const price_per = document.querySelector(".price_per").value; // ราคาต่อชิ้น

    const quantity2 = document.querySelector(".quantity2").value;
    const price_pe2 = document.querySelector(".price_per2").value; // ราคาต่อชิ้น

    /* const quantityBuy = document.querySelector(".quantityBuy").value; // ราคาต่อชิ้น
    const price_perBuy = document.querySelector(".price_perBuy").value; */

    /*     console.log(price_perBuy, quantityBuy); */
    if (quantity && price_per) {
        const sum = quantity * price_per;
        $("#total_price").val(sum);
    }
    if (quantity2 && price_pe2) {
        const sum = quantity2 * price_pe2;
        $("#total_price2").val(sum);
    }
    /*     if (price_perBuy && quantityBuy) {
        const sum = quantityBuy * quantityBuy;
        $("#total_priceBuy").val(sum);
    } */
}

function calculateTotalPrice2() {
    const quantityBuy = document.querySelector(".quantityBuy").value; // ราคาต่อชิ้น
    const price_perBuy = document.querySelector(".price_perBuy").value;
    const quantityBuy2 = document.querySelector(".quantityBuy2").value; // ราคาต่อชิ้น
    const price_perBuy2 = document.querySelector(".price_perBuy2").value;

    console.log(quantityBuy2, price_perBuy2);
    if (quantityBuy && price_perBuy) {
        const sum = quantityBuy * price_perBuy;
        $("#total_priceBuy").val(sum);
    }
    if (quantityBuy2 && price_perBuy2) {
        const sum = quantityBuy2 * price_perBuy2;
        $("#total_priceBuy2").val(sum);
    }
}

function durableArticlesCode() {
    const quantity = document.getElementById("durable_articles_code").value; // จำนวน

    $.ajax({
        url: "/post-durableArticles",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"), // Fetch the CSRF token
        },
        data: { quantity },
        success: function (res) {
            console.log("res", res);
            if (res.length > 0 && res.length < 2) {
                if (
                    res[0].damaged_number == 0 &&
                    res[0].bet_on_distribution_number == 0 &&
                    res[0].repair_number == 0
                ) {
                    $("#damaged_number_error").text("");
                    $("#durable_id").val(res[0].id);
                    $("#durable_group").val(res[0].category_name);
                    $("#durable_name").val(res[0].type_name);
                    $("#durable_description").val(res[0].durableArticles_name);
                } else {
                    $("#damaged_number_error").text(
                        "ครุภัณฑ์ลงทะเบียนชำรุดเเล้ว"
                    );
                }
            } else {
                $("#durable_id").val("");
                $("#durable_group").val("");
                $("#durable_name").val("");
                $("#durable_description").val("");
                $("#damaged_number_error").text("");
                $("#damaged_number_error").text("ไม่พบครุภัณฑ์ลงทะเบียน");
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
    console.log("5555");
}
