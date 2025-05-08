$(document).ready(function () {
  let currentId = null;

  // Mở modal thêm
  $("#add").click(function () {
    $("#modal").show();
  });

  // Đóng modal
  $(".close").click(function () {
    $("#modal, #editModal").hide();
  });

  // Thêm câu hỏi
  $("#submit").click(function () {
    const data = {
      question: $("#question").val(),
      A: $("#A").val(),
      B: $("#B").val(),
      C: $("#C").val(),
      D: $("#D").val(),
      answer: $("#answer").val(),
      chapter: $("#chapter").val(),
    };

    $.post("../controllers/add_question.php", data, function (res) {
      alert(res);
      location.reload();
    });
  });
});
// Mở modal sửa
$(document).on("click", ".editBtn", function () {
  const row = $(this).closest("tr");
  currentId = row.data("id");

  $("#edit_question").val(row.find(".question").text());
  $("#edit_A").val(row.find(".A").text());
  $("#edit_B").val(row.find(".B").text());
  $("#edit_C").val(row.find(".C").text());
  $("#edit_D").val(row.find(".D").text());
  $("#edit_answer").val(row.find(".answer").text());
  $("#edit_chapter").val(row.find(".chapter").text());

  $("#editModal").show();
});

// Cập nhật câu hỏi
$("#update").click(function () {
  const data = {
    id: currentId,
    question: $("#edit_question").val(),
    A: $("#edit_A").val(),
    B: $("#edit_B").val(),
    C: $("#edit_C").val(),
    D: $("#edit_D").val(),
    answer: $("#edit_answer").val(),
    chapter: $("#edit_chapter").val(),
  };

  $.post("../controllers/edit_question.php", data, function (res) {
    alert(res);
    location.reload();
  });
});

// Xóa câu hỏi
$(document).on("click", ".deleteBtn", function () {
  const id = $(this).closest("tr").data("id");
  if (confirm("Bạn có chắc chắn muốn xóa câu hỏi này?")) {
    $.post("../controllers/delete_question.php", { id }, function (res) {
      alert(res);
      location.reload();
    });
  }
});
