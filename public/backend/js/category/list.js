function actionDelete(event){
    event.preventDefault();
    let urlRequest = $(this).data('url');
    let that = $(this);
    Swal.fire({
        title: "Bạn có chắc chắn xóa?",
        text: "Bạn sẽ không thể hoàn tác!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Có, Xóa nó!"
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type:'GET',
                url:urlRequest,
                success:function(data){
                    if(data.code==200 && data.message == 'success'){
                        that.parent().parent().remove();
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Xóa danh mục thành công!',
                            showConfirmButton: false,
                            timer: 15000,
                            toast: true
                        });
                    }
                    else if(data.code == 200 && data.message == 'error'){
                        console.log('Mã hiện đang chạy');
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Xóa danh mục không thành công vì tồn tại sản phẩm bên trong',
                            showConfirmButton: false,
                            timer: 15000,
                            toast: true
                        });
                    }
                },
                error:function(){

                }
            });

        }
      });
}

$(function(){
    $(document).on('click','.action_delete', actionDelete );
    // alert(1);
});