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

//อนุมัติ
if (targetUrls === "approval-update") {
    setActiveClass("approval", "approval-update");
}
console.log("targetUrls", targetUrls);

function myFunction(selectedValue) {
    // ทำอะไรก็ตามที่คุณต้องการเมื่อมีการเปลี่ยนแปลงค่าใน <select>
    // เช่น เรียกใช้ AJAX เพื่อโหลดข้อมูลเพิ่มเติม, ส่งค่าไปที่ฟอร์ม, หรืออื่น ๆ

    document.getElementById("myForm").submit();

    // ทำต่อไปตามความต้องการ
}

var globalRes; // สร้างตัวแปร global เพื่อเก็บค่า res
var globalResType; // สร้างตัวแปร global เพื่อเก็บค่า res

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
    console.log("5555", selectedValue);
    $.ajax({
        url: "get-categoriesData/" + selectedValue,
        type: "GET",
        success: function (res) {
            console.log("res", res);
            globalRes = res;
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

            $.each(res, function (index, data) {
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
    if (foundItem) {
        $("#categories_id").val(
            globalResType == 1
                ? foundItem.code_material
                : foundItem.group_class +
                      "-" +
                      foundItem.type_durableArticles +
                      "-" +
                      foundItem.description +
                      "-" +
                      foundItem.group_count
        );
        $("#counting_unit").val(
            globalResType == 1
                ? foundItem.name_material_count
                : foundItem.name_durableArticles_count
        );

        if (globalResType == 2) {
            $("#quantity").val(foundItem.durableArticles_number);
            $("#quantity").attr("readonly", true);
        } else {
            $("#quantity").attr("readonly", false);
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

    // ใช้ globalRes ที่เก็บค่า res จาก getGroup
    var foundItem = materialRes.find(function (item) {
        return item.id == selectedValue;
    });
    if (foundItem) {
        if (foundItem.remaining_amount == 0) {
            document.getElementById("out-stock").textContent =
                " วัสดุหมดแล้ว ไม่สามารถเบิกได้";
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

$("#details-name").on("change", function () {
    const selectedValue = $(this).val(); // รับค่าที่ถูกเลือก
    var foundItem = details_name.find(function (item) {
        return item.id == selectedValue;
    });

    if (foundItem) {
        if (foundItem.remaining_amount == 0) {
            document.getElementById("out-stock").textContent =
                " วัสดุหมดแล้ว ไม่สามารถเบิกได้";
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
        $("#durable_articles_id").val(foundItem.code_DurableArticles);
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
                        value: data.type_code,
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

$("#details_repair_name").on("change", function () {
    var selectedValue = $(this).val(); // รับค่าที่ถูกเลือก
    console.log("selectedValue", selectedValue);
    // ใช้ globalRes ที่เก็บค่า res จาก getGroup
    var foundItem = detailsRepairNameRes.find(function (item) {
        return item.durable_articles_id == selectedValue;
    });
    console.log("foundItem", foundItem);

    if (foundItem) {
        document
            .getElementById("amount_withdraw")
            .setAttribute("max", foundItem.durableArticles_number);
        $("#code_durable_articles").val(foundItem.code_durable_articles);
        $("#amount_withdraw").val(foundItem.amount_damaged);
        $("#name-durable_articles-count").val(
            foundItem.name_durable_articles_count
        );
        $("#durable_articles_id").val(foundItem.durable_articles_id);
        $("#durable_articles_name").val(foundItem.durable_articles_name);
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
                    text: "เลือกวัสดุ",
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
}

$("#calculate-id").on("change", function () {
    var selectedValue = $(this).val(); // รับค่าที่ถูกเลือก
    console.log("6666");
    // ใช้ globalRes ที่เก็บค่า res จาก getGroup
    var foundItem = calculateRes.find(function (item) {
        return item.id == selectedValue;
    });

    console.log("foundItem", foundItem);
    if (foundItem) {
        $("#articles_id").val(foundItem.id);
        $("#categories_id").val(
            foundItem.group_class +
                "-" +
                foundItem.type_durableArticles +
                "-" +
                foundItem.description
        );

        $("#quantity").val(foundItem.durableArticles_number);
        $("#counting_unit").val(foundItem.name_durableArticles_count);
        $("#price_per_piece").val(
            Number(foundItem.price_per_piece).toLocaleString()
        );

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

        let ageMultiplier = ageInYears + 1; //ปี

        $("#service_life").val(ageMultiplier);

        if (foundItem.salvage_price == 0) {
            // คำนวณค่าเสื่อม (ราคา * ค่าเสื่อม/100) / ปี (กรณีที่ยังไม่ได้จำหน่าย)
            let price = (foundItem.price_per_piece * 20) / 100 / ageMultiplier;
            $("#calulate-depreciation").val(price.toLocaleString());
        } else {
            // คำนวณค่าเสื่อม (ราคา - ราคาซาก) / ปี (กรณีที่จำหน่าย)
            let price =
                (foundItem.price_per_piece - foundItem.salvage_price) /
                ageMultiplier;
            $("#calulate-depreciation").val(price.toLocaleString());
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
