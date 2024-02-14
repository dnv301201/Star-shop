$(document).on('click', '.remove-product-btn', function (event) {
    event.preventDefault();
    let urlRequest = $(this).attr('href'); // Lấy URL từ thuộc tính href của nút xóa

    Swal.fire({
        title: "Bạn chắc chắn?",
        text: "Bạn sẽ không thể hoàn lại thao tác này!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Có, Xóa nó!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'GET',
                url: urlRequest,
                success: function (data) {
                    if (data.code === 200) {
                        // xóa hàng hóa khỏi giao diện người dùng nếu xóa thành công
                        $(event.target).closest('tr').remove();

                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Xóa thành công!',
                            showConfirmButton: false,
                            timer: 5000,
                            toast: true,
                            onClose: function () {
                                location.reload();
                            }               
                        });
                        if ($('.table tbody tr').length === 0) {
                            $('.cart-table').hide(); // Ẩn bảng sản phẩm
                        }
                    } else {
                        // Xử lý khi xóa không thành công
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Xóa sản phẩm không thành công!'
                        });
                    }
                },
                error: function () {
                    // Xử lý lỗi khi gọi Ajax
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Đã xảy ra lỗi khi xóa sản phẩm!'
                    });
                }
            });
        }
    });
});