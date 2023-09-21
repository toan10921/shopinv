import './bootstrap';
import $ from 'jquery';
window.$ = $;

$(document).ready(function () {

    $('.btn-delete-product').click(function () {
        let cf = confirm('Are you sure?');
        if (!cf) {
            return;
        }
        var id = $(this).data('id');
        let url = $('#form_delete_product').attr('data-url');
        $('#form_delete_product').attr('action', url + "/" + id);
        // $('#delete-submit').click();
        $('#delete-submit')[0].click();
    });
    $('.quantity-wrap .btn').on('click', function (e) {
        e.preventDefault();
        let $this = $(this);
        if ($this.hasClass('btn-plus')) {
            let $input = $this.siblings('input');
            let val = parseInt($input.val());
            $input.val(val + 1);
        } else if ($this.hasClass('btn-minus')) {
            let $input = $this.siblings('input');
            let val = parseInt($input.val());
            if (val > 1) {
                $input.val(val - 1);
            }
        }
    });

    function handleMiniCart() {
        // read session storage
        let parent = $('.mini-cart-wrap');

        let cart = JSON.parse(sessionStorage.getItem('cart'));
        if (cart === null) {
            cart = [];
        }
        let total = 0;
        let html = '';
        html += '<div class="mini-cart-items">';
        for (let i = 0; i < cart.length; i++) {
            let item = cart[i];
            total += item.quantity * item.price;
            html += '<div class="mini-cart-item d-flex align-items-center">';
            html += '<div class="mini-cart-item-image">';
            html += '<a href="#"><img src="' + item.thumbnail + '" alt=""></a>';
            html += '</div>';
            html += '<div class="mini-cart-item-des">';
            html += '<a href="#">' + item.name + '</a>';
            html += '<span class="mini-cart-item-quantity">' + item.quantity + ' x <span>' + item.price + '</span></span>';
            html += '</div>';
            html += '<a href="#" class="btn-remove" data-id="'+item.id+'">Remove</a>';
            html += '</div>';
        }
        html += '</div>';
        html += '<div class="mini-cart-total">';
        html += '<span>Total</span>';
        html += '<span class="total-price">' + total + '</span>';
        html += '</div>';

        $('#mini-cart').html(html);
        // update btn mini cart and total price
        parent.find('.btn-open-cart .cart-number').text(cart.length);
        parent.find('.cart-total').text(total + " $");

    }

    handleMiniCart();

    $('#mini-cart').hide();

    $(document).find('#mini-cart').on('change', function () {
        handleMiniCart();
        $('#mini-cart').show();
    });

    $('.btn-open-cart').on('click', function (e) {
        e.preventDefault();
        $('#mini-cart').toggle();
    });

    $(document).on('click', '.btn-remove', function (e) {

        e.preventDefault();
        let $this = $(this);
        let cart = JSON.parse(sessionStorage.getItem('cart'));
        if (cart === null) {
            cart = [];
        }
        let index = cart.findIndex(x => x.id === $this.data('id'));
        console.log(index);
        if (index !== -1) {
            cart.splice(index, 1);
        }
        sessionStorage.setItem('cart', JSON.stringify(cart));
        $('#mini-cart').trigger('change');
    });

    $('.btn-add-cart').on('click', function (e) {
        e.preventDefault();
        let $this = $(this);
        let quantity = $this.parents('.add-cart-wrap').find('.quantity-wrap input.quantity').val();
        let productid = $this.data('id');
        let productname = $this.data('name');
        let productprice = $this.data('price');
        let productthumbnail = $this.data('thumbnail');
        let cart = JSON.parse(sessionStorage.getItem('cart'));
        if (cart === null) {
            cart = [];
        }
        let index = cart.findIndex(x => x.id === productid);
        if (index === -1) {
            cart.push({
                id: productid,
                quantity: quantity,
                name: productname,
                price: productprice,
                thumbnail: productthumbnail
            });
        }else{
            cart[index].quantity = parseInt(cart[index].quantity) + parseInt(quantity);
        }
        sessionStorage.setItem('cart', JSON.stringify(cart));
        $('#mini-cart').trigger('change');
    });

    $('.product-galleries .gallery-item').on('click', function (e) {
        e.preventDefault();
        let $this = $(this);
        let src = $this.find('img').attr('src');
        console.log( $this.parents('.product-galleries'));
        $this.parents('.thumbnail-wrap').find('.thumbnail-inner img').attr('src', src);
    });

});
