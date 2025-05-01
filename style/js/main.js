document.getElementById('dateofbirth').addEventListener('change', function () {
    const selectedDate = new Date(this.value);
    const today = new Date();

    if (selectedDate > today) {
        alert('Ngày sinh không được là ngày trong tương lai.');
        this.value = '';
    }
});
document.querySelector('.myform').addEventListener('submit', function (e) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm-password').value;

    if (password !== confirmPassword) {
        e.preventDefault(); // Ngăn gửi form
        alert('Mật khẩu không khớp. Vui lòng kiểm tra lại.');
    }
});

const urlParams = new URLSearchParams(window.location.search);
const message = urlParams.get('message');

if (message === 'success') {
    alert('Dữ liệu của bạn đã được đăng ký thành công!');
} else if (message === 'error') {
    alert('Có lỗi xảy ra khi đăng ký. Vui lòng thử lại!');
}