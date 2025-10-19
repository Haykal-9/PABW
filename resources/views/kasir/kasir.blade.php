@extends('layouts.kasir')
@section('title', 'Halaman Kasir')

@push('styles')
  {{-- ganti path static menjadi asset() --}}
  <link rel="stylesheet" href="{{ asset('css/kasir_prefixed.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush

@section('content')
<div class="kasir-page">
  <main>
    <header>
      <h1>Kasir - Tapal Kuda</h1>
      <p>Silakan pilih menu untuk menambahkan ke pesanan</p>
    </header>

    <nav class="tabs">
      <button class="tab-link active">Semua</button>
      <div class="search-container">
        <i class="fas fa-search icon-search"></i>
        <input type="search" placeholder="Cari menu..." id="searchInput">
      </div>
    </nav>

    {{-- =========================
         PILIH MENU (DARI CONTROLLER)
         ========================= --}}
    <section class="choose-dishes">
      <h2>Pilih Menu</h2>
      <div class="dishes-grid" id="menuGrid">

        @forelse ($menu as $m)
          <div class="dish-card" data-name="{{ strtolower($m['nama']) }}">
            {{-- jika img dari controller adalah URL, pakai langsung; jika file lokal: ganti ke asset('assets/xxx.jpg') --}}
            <img src="{{ $m['img'] }}" alt="{{ $m['nama'] }}">
            <h3>{{ $m['nama'] }}</h3>
            <p class="price">Rp{{ number_format($m['harga'], 0, ',', '.') }}</p>
            <p class="available">Tersedia</p>
            <button class="add-to-order" data-id="{{ $m['id'] }}">
              <i class="fas fa-plus"></i>
            </button>
          </div>
        @empty
          <p class="text-muted">Belum ada menu yang tersedia.</p>
        @endforelse

      </div>
    </section>
  </main>

  <aside class="orders-panel">
    <header>
      <h2>Pesanan <span id="orderItemCount">(0 item)</span></h2>
    </header>

    <ul class="order-list" id="orderList"></ul>

    <footer>
      <div class="subtotal">
        <span>Subtotal</span><span id="subtotalHarga">Rp0</span>
      </div>
      <div class="discount">
        <span style="color: white;">Diskon</span><span style="color: white;">Rp0</span>
      </div>
      <div class="discount">
        <span style="color: white;">Pajak (10%)</span><span id="pajakHarga" style="color: white;">Rp0</span>
      </div>
      <div class="subtotal">
        <span style="color: white;">Total</span><span id="totalHarga" style="color: white;">Rp0</span>
      </div>
      <button id="bayarBtn" style="color: white;">Bayar Sekarang</button>
    </footer>
  </aside>
</div>

{{-- =========================
     SCRIPT ASLI MU (tetap)
     ========================= --}}
<script>
  // Pencarian menu lokal
  document.getElementById("searchInput").addEventListener("input", function () {
    const value = this.value.toLowerCase();
    document.querySelectorAll(".dish-card").forEach(card => {
      const name = card.getAttribute("data-name");
      card.style.display = name.includes(value) ? "flex" : "none";
    });
  });

  // Tambah ke keranjang (masih mengarah ke endpoint lama php native; ganti ke route Laravel kalau sudah siap)
  document.querySelectorAll('.add-to-order').forEach(button => {
    button.addEventListener('click', function () {
      const menuId = this.dataset.id;
      fetch('logic/add_to_cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'menu_id=' + menuId
      })
      .then(res => res.json())
      .then(data => {
        updateCartUI(data);
      });
    });
  });

  // Load cart saat halaman dibuka
  window.onload = function () {
    const urlParams = new URLSearchParams(window.location.search);
    const errorMsg = urlParams.get('error_msg');
    if (errorMsg) {
      alert("Error: " + decodeURIComponent(errorMsg));
      window.history.replaceState({}, document.title, window.location.pathname);
    }

    fetch('logic/get_cart.php')
      .then(res => res.json())
      .then(data => {
        updateCartUI(data);
      });
  };

  function updateCartUI(data) {
    const list = document.getElementById("orderList");
    const headerText = document.querySelector(".orders-panel header h2 span");
    const bayarBtn = document.getElementById("bayarBtn");
    const submitCheckoutBtn = document.getElementById("submitCheckoutBtn");

    let total = 0;
    let html = '';
    data.forEach(item => {
      html += `
        <li>
          <img src="{{ asset('assets') }}/${item.url_foto}" />
          <div class="order-info">
            <p class="name">${item.nama}</p>
            <p class="price">Rp${item.subtotal.toLocaleString()}</p>
            <input type="text" value="${item.item_notes || ''}" placeholder="Catatan..." data-id="${item.menu_id}" onchange="updateNote(this)">
          </div>
          <div class="order-qty-delete">
            <div class="qty-controls">
              <button onclick="changeQty(${item.menu_id}, -1)">-</button>
              <span class="qty">${item.quantity}</span>
              <button onclick="changeQty(${item.menu_id}, 1)">+</button>
            </div>
            <button class="delete-btn" onclick="deleteItem(${item.menu_id})"><i class="fas fa-trash"></i></button>
          </div>
        </li>
      `;
      total += parseInt(item.subtotal);
    });

    const pajak = Math.round(total * 0.10);
    const diskon = 0;
    const totalAkhir = total - diskon + pajak;

    list.innerHTML = html;
    headerText.textContent = `(${data.length} item)`;
    document.getElementById("subtotalHarga").textContent = "Rp" + total.toLocaleString();
    document.querySelector(".discount span:last-child").textContent = "Rp" + diskon.toLocaleString();
    document.getElementById("pajakHarga").textContent = "Rp" + pajak.toLocaleString();
    document.getElementById("totalHarga").textContent = "Rp" + totalAkhir.toLocaleString();

    if (data.length > 0) {
      bayarBtn.disabled = false;
      bayarBtn.style.opacity = '1';
      bayarBtn.style.cursor = 'pointer';
      if (submitCheckoutBtn) {
        submitCheckoutBtn.disabled = false;
        submitCheckoutBtn.style.opacity = '1';
        submitCheckoutBtn.style.cursor = 'pointer';
      }
    } else {
      bayarBtn.disabled = true;
      bayarBtn.style.opacity = '0.5';
      bayarBtn.style.cursor = 'not-allowed';
      if (submitCheckoutBtn) {
        submitCheckoutBtn.disabled = true;
        submitCheckoutBtn.style.opacity = '0.5';
        submitCheckoutBtn.style.cursor = 'not-allowed';
      }
    }
  }

  function changeQty(id, delta) {
    fetch('logic/update_cart.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `menu_id=${id}&delta=${delta}`
    })
    .then(res => res.json())
    .then(data => updateCartUI(data));
  }

  function deleteItem(id) {
    fetch('logic/delete_from_cart.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `menu_id=${id}`
    })
    .then(res => res.json())
    .then(data => updateCartUI(data));
  }

  function updateNote(input) {
    const id = input.dataset.id;
    const note = input.value;
    fetch('logic/update_cart.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `menu_id=${id}&note=${encodeURIComponent(note)}`
    });
  }

  document.getElementById("bayarBtn").onclick = function () {
    if (!this.disabled) {
      document.getElementById("checkoutModal").style.display = "flex";
    }
  };

  function closeModal() {
    document.getElementById("checkoutModal").style.display = "none";
  }

  document.getElementById("checkoutForm").onsubmit = function (e) {
    const submitBtn = document.getElementById("submitCheckoutBtn");
    if (submitBtn && submitBtn.disabled) {
      alert("Transaksi tidak dapat dilakukan: Keranjang kosong atau ada masalah.");
      e.preventDefault();
      return;
    }

    const checkoutItems = [];
    document.querySelectorAll('#orderList li').forEach(itemElement => {
      const menuId = itemElement.querySelector('.delete-btn').dataset.id;
      const quantity = parseInt(itemElement.querySelector('.qty').textContent);
      const priceText = itemElement.querySelector('.price').textContent;
      const price = parseInt(priceText.replace('Rp', '').replace(/\./g, ''));
      const name = itemElement.querySelector('.name').textContent;
      const notes = itemElement.querySelector('input[type="text"]').value;
      const fotoUrl = itemElement.querySelector('img').src;
      const fotoName = fotoUrl.substring(fotoUrl.lastIndexOf('/') + 1);

      checkoutItems.push({
        id: menuId,
        name: name,
        price: price,
        quantity: quantity,
        note: notes,
        foto: fotoName
      });
    });

    document.getElementById('checkoutItemsInput').value = JSON.stringify(checkoutItems);
  };
</script>

{{-- Modal checkout (tetap seperti aslinya) --}}
<div id="checkoutModal"
  style="display:none; position:fixed; left:0; top:0; right:0; bottom:0; background:rgba(30,36,50,0.85); z-index:999; justify-content:center; align-items:center;">
  <form id="checkoutForm" action="logic/checkout.php" method="post"
    style="background:#222b3a;padding:32px;border-radius:12px;max-width:340px;width:100%;margin:auto;box-shadow:0 2px 24px #0006;color:#fff;">
    <h2 style="margin-bottom:20px;">Pembayaran</h2>
    <label>Nama Customer (opsional):<br>
      <input type="text" name="customer_name"
        style="width:100%;margin-bottom:12px;padding:8px;border-radius:8px;border:none;">
    </label>

    {{-- Jenis Pesanan & Metode Pembayaran masih placeholder native;
         nanti bisa diganti data dari controller juga jika diperlukan --}}

    <label>Kode Voucher (jika ada):<br>
      <input type="text" name="voucher_code"
        style="width:100%;margin-bottom:18px;padding:8px;border-radius:8px;border:none;">
    </label>

    <input type="hidden" name="items" id="checkoutItemsInput">
    <button type="submit" id="submitCheckoutBtn"
      style="width:100%;background:#e07b6c;padding:12px 0;border:none;border-radius:10px;font-weight:700;color:#fff;">
      Bayar & Cetak Struk
    </button>
    <button type="button" onclick="closeModal()"
      style="width:100%;margin-top:8px;padding:10px 0;border:none;border-radius:10px;background:#222b3a;color:#e07b6c;">
      Batal
    </button>
  </form>
</div>
@endsection
