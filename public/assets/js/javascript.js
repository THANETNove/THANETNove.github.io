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
    $.ajax({
        url: "get-categoriesData/" + selectedValue,
        type: "GET",
        success: function (res) {
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
                      foundItem.description
        );
        $("#counting_unit").val(
            globalResType == 1
                ? foundItem.name_material_count
                : foundItem.name_durableArticles_count
        );
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

//เลือกชื่อวัสดุ
function selectMaterialId(selectedValue) {
    $.ajax({
        url: "get-materialId/" + selectedValue,
        type: "GET",
        success: function (res) {
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
        $("#code_requisition").val(foundItem.code_material);
        $("#remaining-amount").val(foundItem.remaining_amount);
        $("#name-material-count").val(foundItem.name_material_count);
    }
});
