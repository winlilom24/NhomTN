<!-- Modal để thêm câu hỏi -->
<div id="modal" style="display:none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Thêm câu hỏi mới</h2>
            <form id="addForm">
                <label for="question">Câu hỏi:</label><br>
                <input type="text" id="question" name="question" required><br><br>

                <label for="A">Câu A:</label><br>
                <input type="text" id="A" name="A" required><br><br>

                <label for="B">Câu B:</label><br>
                <input type="text" id="B" name="B" required><br><br>

                <label for="C">Câu C:</label><br>
                <input type="text" id="C" name="C" required><br><br>

                <label for="D">Câu D:</label><br>
                <input type="text" id="D" name="D" required><br><br>

                <label for="answer">Đáp án:</label><br>
                <input type="text" id="answer" name="answer" required><br><br>

                <label for="chapter">Chương:</label><br>
                <input type="text" id="chapter" name="chapter" required><br><br>

                <button type="button" id="submit">Thêm câu hỏi</button>
            </form>
        </div>
    </div>
<!-- Modal để cập nhật câu hỏi -->
<div id="editModal" style="display:none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Sửa câu hỏi</h2>
        <form id="editForm">
            <label for="edit_question">Câu hỏi:</label><br>
            <input type="text" id="edit_question" name="question" required><br><br>

            <label for="edit_A">Câu A:</label><br>
            <input type="text" id="edit_A" name="A" required><br><br>

            <label for="edit_B">Câu B:</label><br>
            <input type="text" id="edit_B" name="B" required><br><br>

            <label for="edit_C">Câu C:</label><br>
            <input type="text" id="edit_C" name="C" required><br><br>

            <label for="edit_D">Câu D:</label><br>
            <input type="text" id="edit_D" name="D" required><br><br>

            <label for="edit_answer">Đáp án:</label><br>
            <input type="text" id="edit_answer" name="answer" required><br><br>

            <label for="edit_chapter">Chương:</label><br>
            <input type="text" id="edit_chapter" name="chapter" required><br><br>

            <button type="button" id="update">Cập nhật</button>
        </form>
    </div>
</div>