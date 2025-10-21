@extends('kasir.layouts.app')

{{-- CSS Khusus untuk halaman kasir --}}
@push('styles')
<style>
    /* Override grid-template-columns untuk halaman kasir */
    .main-container {
        grid-template-columns: 80px 1fr 380px;
    }
    .content { padding: 2rem; }
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }
    /* ... (semua style lain dari file HTML kasir) ... */
    .menu-card { background-color: var(--card-bg); border: none; border-radius: 1rem; overflow: hidden; transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer; }
    .menu-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.2); }
    .menu-card .card-img-container { position: relative; }
    .menu-card img { height: 150px; object-fit: cover; width: 100%; }
    .add-btn { position: absolute; top: 0.5rem; right: 0.5rem; background-color: var(--accent-color); color: white; border: none; border-radius: 50%; width: 30px; height: 30px; font-size: 1.2rem; line-height: 1; display: flex; align-items: center; justify-content: center; transition: background-color 0.3s ease; }
    .add-btn:hover { background-color: #d16a2f; }
    .menu-card .card-body { padding: 1rem; }
    .menu-card .card-title { font-size: 1rem; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .menu-card .card-text { color: var(--accent-color); font-weight: 500; }
    .cart-section { background-color: var(--sidebar-bg); padding: 2rem; display: flex; flex-direction: column; border-left: 1px solid var(--border-color); height: 100vh; grid-column: 3 / 4; grid-row: 1 / -1; }
    .cart-header h4 { font-weight: 600; }
    #cart-items { flex-grow: 1; overflow-y: auto; margin-top: 1.5rem; }
    .cart-item { display: flex; align-items: center; margin-bottom: 1.5rem; }
    .cart-item img { width: 50px; height: 50px; border-radius: 50%; object-fit: cover; margin-right: 1rem; }
    .cart-item-details { flex-grow: 1; }
    .cart-item-details h6 { margin: 0; font-size: 0.9rem; font-weight: 500; }
    .cart-item-details p { margin: 0; font-size: 0.8rem; color: var(--text-muted-color); }
    .cart-item-actions { display: flex; align-items: center; gap: 0.5rem; }
    .quantity-btn { background-color: var(--card-bg); border: 1px solid var(--border-color); color: var(--text-color); width: 28px; height: 28px; border-radius: 0.25rem; }
    .cart-summary { border-top: 1px solid var(--border-color); padding-top: 1.5rem; }
    .summary-row { display: flex; justify-content: space-between; margin-bottom: 0.75rem; font-size: 0.9rem; }
    .summary-row.total { font-size: 1.1rem; font-weight: 600; margin-top: 1rem; }
    .summary-row.total span:last-child { color: var(--accent-color); }
    .btn-checkout { background-color: var(--accent-color); border: none; width: 100%; padding: 0.75rem; font-weight: 600; border-radius: 0.5rem; }
    .btn-checkout:hover { background-color: #d16a2f; }
    #cart-toggle { display: none; } /* Initially hidden */

    @media (max-width: 992px) {
        .main-container { grid-template-columns: 1fr; }
        .cart-section { position: fixed; top: 0; right: -100%; width: 320px; z-index: 1001; transition: right 0.3s ease-in-out; }
        .cart-section.open { right: 0; }
        #cart-toggle { display: block; position: fixed; top: 1rem; right: 1rem; z-index: 1002; background-color: var(--accent-color); color: white; border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 1.5rem; }
    }
</style>
@endpush

@section('content')
<main class="content">
    <div class="header">
        <h1>Kasir - Tapal Kuda</h1>
        <p>Silakan pilih menu untuk menambahkan ke pesanan</p>
    </div>
    <div id="menu-container" class="menu-grid">
        {{-- Kartu menu akan dirender oleh JavaScript --}}
    </div>
</main>

<aside class="cart-section" id="cart-section">
    <div class="cart-header">
        <h4>Pesanan <span class="badge bg-secondary" id="cart-count">0 item</span></h4>
    </div>
    <div id="cart-items" class="mt-4">
        {{-- Item keranjang akan dirender oleh JavaScript --}}
    </div>
    <div class="cart-summary">
        <div class="summary-row">
            <span>Subtotal</span>
            <span id="subtotal">Rp0</span>
        </div>
        <div class="summary-row">
            <span>Pajak (10%)</span>
            <span id="tax">Rp0</span>
        </div>
        <hr class="my-2 border-secondary">
        <div class="summary-row total">
            <span>Total</span>
            <span id="total">Rp0</span>
        </div>
        <button class="btn btn-primary w-100 mt-3 btn-checkout">Bayar Sekarang</button>
    </div>
</aside>

<button id="cart-toggle"><i class="bi bi-cart-fill"></i></button>

{{-- Modal Pembayaran --}}
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Pembayaran</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="payment-form">
                    <div class="mb-3">
                        <label for="customer-name" class="form-label">Nama Customer (opsional)</label>
                        <input type="text" class="form-control" id="customer-name" placeholder="Masukkan nama customer">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Pesanan</label>
                        <div>
                            <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="orderType" id="dine-in" value="Dine In" checked><label class="form-check-label" for="dine-in">Dine In</label></div>
                            <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="orderType" id="take-away" value="Take Away"><label class="form-check-label" for="take-away">Take Away</label></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="payment-method" class="form-label">Metode Pembayaran</label>
                        <select class="form-select" id="payment-method"><option value="QRIS">QRIS</option><option value="E-Wallet">E-Wallet</option><option value="Cash" selected>Cash</option></select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="submit-payment-btn">Bayar & Cetak Struk</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- MENGAMBIL DATA DARI CONTROLLER ---
    const menuItems = {!! json_encode($menu) !!}.map(item => ({...item, price: item.harga, name: item.nama }));
    let cart = {!! json_encode($order_items) !!}.map(item => ({...item, price: item.harga, name: item.nama, quantity: item.qty}));

    // --- DOM ELEMENTS ---
    const menuContainer = document.getElementById('menu-container');
    const cartItemsContainer = document.getElementById('cart-items');
    const cartCount = document.getElementById('cart-count');
    const subtotalEl = document.getElementById('subtotal');
    const taxEl = document.getElementById('tax');
    const totalEl = document.getElementById('total');
    const cartToggle = document.getElementById('cart-toggle');
    const cartSection = document.getElementById('cart-section');
    const checkoutBtn = document.querySelector('.btn-checkout');
    const paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));

    // --- Sisa JavaScript sama persis dengan file HTML sebelumnya ---
    const formatRupiah = (number) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);

    const renderMenuItems = () => {
        menuContainer.innerHTML = '';
        menuItems.forEach(item => {
            const card = document.createElement('div');
            card.className = 'menu-card';
            card.innerHTML = `<div class="card-img-container"><img src="${item.img}" class="card-img-top" alt="${item.name}"><button class="add-btn" data-id="${item.id}">+</button></div><div class="card-body"><h5 class="card-title">${item.name}</h5><p class="card-text">${formatRupiah(item.price)}</p></div>`;
            menuContainer.appendChild(card);
        });
    };

    const renderCart = () => {
        cartItemsContainer.innerHTML = '';
        if (cart.length === 0) {
            cartItemsContainer.innerHTML = '<p class="text-center text-muted">Keranjang Anda kosong</p>';
        } else {
            cart.forEach(item => {
                const cartItemDiv = document.createElement('div');
                cartItemDiv.className = 'cart-item';
                cartItemDiv.innerHTML = `<img src="${item.img}" alt="${item.name}"><div class="cart-item-details"><h6>${item.name}</h6><p>${formatRupiah(item.price)}</p></div><div class="cart-item-actions"><button class="quantity-btn" data-id="${item.id}" data-action="decrease">-</button><span class="quantity mx-2">${item.quantity}</span><button class="quantity-btn" data-id="${item.id}" data-action="increase">+</button></div>`;
                cartItemsContainer.appendChild(cartItemDiv);
            });
        }
        updateTotals();
    };

    const updateTotals = () => {
        const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const tax = subtotal * 0.10;
        const total = subtotal + tax;
        subtotalEl.textContent = formatRupiah(subtotal);
        taxEl.textContent = formatRupiah(tax);
        totalEl.textContent = formatRupiah(total);
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        cartCount.textContent = `${totalItems} item${totalItems !== 1 ? 's' : ''}`;
        checkoutBtn.disabled = totalItems === 0;
    };
    
    const addToCart = (itemId) => {
        const itemInCart = cart.find(item => item.id === itemId);
        if (itemInCart) {
            itemInCart.quantity++;
        } else {
            const itemToAdd = menuItems.find(item => item.id === itemId);
            cart.push({ ...itemToAdd, quantity: 1 });
        }
        renderCart();
    };

    const updateQuantity = (itemId, action) => {
        const itemInCart = cart.find(item => item.id === itemId);
        if (itemInCart) {
            if (action === 'increase') itemInCart.quantity++;
            else if (action === 'decrease') {
                itemInCart.quantity--;
                if (itemInCart.quantity <= 0) cart = cart.filter(item => item.id !== itemId);
            }
        }
        renderCart();
    };

    menuContainer.addEventListener('click', (e) => e.target.classList.contains('add-btn') && addToCart(parseInt(e.target.dataset.id)));
    cartItemsContainer.addEventListener('click', (e) => e.target.classList.contains('quantity-btn') && updateQuantity(parseInt(e.target.dataset.id), e.target.dataset.action));
    cartToggle.addEventListener('click', () => cartSection.classList.toggle('open'));
    checkoutBtn.addEventListener('click', () => cart.length > 0 && paymentModal.show());
    
    renderMenuItems();
    renderCart();
});
</script>
@endpush
