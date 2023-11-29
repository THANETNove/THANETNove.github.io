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

$("#code_requisition").on("input", function () {
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
});

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

$("#code_durable_articles").on("input", function () {
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
});

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
    "durable-articles-requisition-show"
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
//อนุมัติ

if (targetUrls === "approval-update") {
    setActiveClass("approval", "approval-update");
}
console.log("targetUrls", targetUrls);
