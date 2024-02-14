let selectedButton = null;

document.querySelectorAll('.color-btn').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();
        const selectedColor = this.getAttribute('data-color');
        const sizeSelect = document.getElementById('sizeSelect');
        sizeSelect.innerHTML = ''; // Xóa tất cả các options cũ trong dropdown size

        // Nếu button đã được click trước đó, thì bấm lại sẽ reset trạng thái ban đầu
        if (selectedButton === this) {
            resetAllButtons();
            return;
        }

        resetAllButtons();
        document.querySelectorAll('.color-btn').forEach(btn => {
            if (btn !== selectedButton) {
                btn.style.backgroundColor = 'grey'; // Đặt màu xám
                btn.style.color = 'black'; // Đặt màu chữ
            }
        });

        // Lưu trữ button được chọn và thay đổi màu của nó
        selectedButton = this;
        selectedButton.style.backgroundColor = 'black'; // Thay đổi màu background
        selectedButton.style.color = 'white'; // Thay đổi màu chữ


        // Lặp qua các element có class 'quantity' để lấy thông tin size tương ứng với selectedColor
        productVersions.forEach(productItem => {
            if (productItem.color === selectedColor) {
                productItem.quantities.forEach(quantity => {
                    addOption(quantity.size);
                });
            }
        });

        function addOption(size) {
            const newOption = document.createElement('option');
            newOption.value = size;
            newOption.text = size;
            sizeSelect.appendChild(newOption); // Thêm option mới cho dropdown size
        }
        if (!document.getElementById('selected_size').value && sizeSelect.options.length > 0) {
            const defaultSize = sizeSelect.options[0].value;
            document.getElementById('selected_size').value = defaultSize;
        }
    });
});

function resetAllButtons() {
    document.querySelectorAll('.color-btn').forEach(btn => {
        btn.style.backgroundColor = ''; // Đặt lại màu background
        btn.style.color = ''; // Đặt lại màu chữ
    });
    selectedButton = null;
}
// Lấy các phần tử cần sử dụng
const minusButton = document.getElementById('minusBtn');
const plusButton = document.getElementById('plusBtn');
const quantityInput = document.getElementById('quantityInput');

// Bắt sự kiện khi nhấn nút "Tăng"
plusButton.addEventListener('click', function() {
  quantityInput.value = parseInt(quantityInput.value) + 1; // Tăng giá trị số lượng lên 1
});

// Bắt sự kiện khi nhấn nút "Giảm"
minusButton.addEventListener('click', function() {
  const currentValue = parseInt(quantityInput.value);
  if (currentValue > 1) {
    quantityInput.value = currentValue - 1; // Giảm giá trị số lượng đi 1, nhưng không dưới 1
  }
});

document.querySelectorAll('.color-btn').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();
        const selectedColor = this.getAttribute('data-color');
        document.getElementById('selected_color').value = selectedColor;


    });
});

document.getElementById('sizeSelect').addEventListener('change', function(event) {
    const selectedSize = this.value;
    document.getElementById('selected_size').value = selectedSize;
});


