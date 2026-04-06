@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Form Checkout --}}
        <div class="lg:col-span-2">
            <form action="{{ route('checkout.process') }}" method="POST" class="bg-white rounded-lg shadow-md p-6">
                @csrf
                
                <h2 class="text-lg font-semibold mb-4">Informasi Pengiriman</h2>
                
                <div class="space-y-4 mb-6">
                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">
                            Alamat Lengkap <span class="text-red-500">*</span>
                        </label>
                        <textarea id="alamat" 
                                  name="alamat" 
                                  rows="3" 
                                  required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-1">
                            Nomor HP <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="no_hp" 
                               name="no_hp" 
                               value="{{ old('no_hp', Auth::user()->no_hp ?? '') }}"
                               required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                        @error('no_hp')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="catatan" class="block text-sm font-medium text-gray-700 mb-1">
                            Catatan (Opsional)
                        </label>
                        <textarea id="catatan" 
                                  name="catatan" 
                                  rows="2"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">{{ old('catatan') }}</textarea>
                    </div>
                </div>

                <h2 class="text-lg font-semibold mb-4">Pengiriman & Pembayaran</h2>
                
                <div class="space-y-4">
                    <div>
                        <label for="jasa_pengiriman" class="block text-sm font-medium text-gray-700 mb-1">
                            Jasa Pengiriman <span class="text-red-500">*</span>
                        </label>
                        <select id="jasa_pengiriman" 
                                name="jasa_pengiriman" 
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                            <option value="">Pilih Jasa Pengiriman</option>
                            @foreach($jasaPengiriman as $jasa)
                                <option value="{{ $jasa }}" {{ old('jasa_pengiriman') == $jasa ? 'selected' : '' }}>
                                    {{ $jasa }}
                                </option>
                            @endforeach
                        </select>
                        @error('jasa_pengiriman')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="metode_pembayaran" class="block text-sm font-medium text-gray-700 mb-1">
                            Metode Pembayaran <span class="text-red-500">*</span>
                        </label>
                        <select id="metode_pembayaran" 
                                name="metode_pembayaran" 
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                            <option value="">Pilih Metode Pembayaran</option>
                            @foreach($metodePembayaran as $key => $detail)
                                <option value="{{ $key }}" {{ old('metode_pembayaran') == $key ? 'selected' : '' }}>
                                    {{ $key }}
                                </option>
                            @endforeach
                        </select>
                        @error('metode_pembayaran')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Detail Pembayaran --}}
                    <div id="paymentDetail" class="hidden bg-gray-50 p-3 rounded-md border border-gray-200">
                        <p class="text-sm font-semibold text-gray-700 mb-1">📋 Detail Pembayaran:</p>
                        <p id="paymentInfo" class="text-sm text-gray-600"></p>
                    </div>
                </div>

                <div class="mt-8">
                    <button type="submit" 
                            class="w-full bg-yellow-500 text-gray-900 py-3 rounded-md hover:bg-yellow-600 transition font-semibold text-lg">
                        Buat Pesanan
                    </button>
                </div>
            </form>
        </div>

        {{-- Ringkasan Pesanan --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold mb-4">Ringkasan Pesanan</h2>
                
                <div class="space-y-3 mb-4 max-h-96 overflow-y-auto">
                    @foreach($carts as $cart)
                        <div class="flex justify-between text-sm">
                            <div>
                                <span class="font-medium">{{ $cart->product->name }}</span>
                                <span class="text-gray-500"> x {{ $cart->quantity }}</span>
                            </div>
                            <span class="font-semibold">
                                Rp {{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                </div>

                <div class="border-t pt-4">
                    <div class="flex justify-between font-semibold text-lg">
                        <span>Total</span>
                        <span class="text-yellow-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const paymentDetails = {
        'Transfer Bank': 'BCA - 1234567890 a/n PT BatuBara Briket',
        'E-Wallet': 'DANA - 081234567890 a/n PT BatuBara Briket',
        'Virtual Account': 'VA BCA - 88881234567890 a/n PT BatuBara Briket'
    };

    document.getElementById('metode_pembayaran').addEventListener('change', function() {
        const selected = this.value;
        const paymentDetailDiv = document.getElementById('paymentDetail');
        const paymentInfo = document.getElementById('paymentInfo');
        
        if (selected && paymentDetails[selected]) {
            paymentInfo.innerHTML = paymentDetails[selected];
            paymentDetailDiv.classList.remove('hidden');
        } else {
            paymentDetailDiv.classList.add('hidden');
        }
    });
</script>
@endpush

@endsection