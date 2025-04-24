<div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
    @foreach ($products as $product)
        <div class="bg-white rounded-2xl shadow p-4">
            @if ($product->image_path)
                <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded-md mb-4">
            @endif
            <h2 class="text-lg font-semibold">{{ $product->name }}</h2>
            <p class="text-gray-600 mb-2">${{ number_format($product->price, 2) }}</p>
            <button
                class="mt-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition"
                wire:click="showDetails({{ $product->id }})">
                Ver detalles
            </button>
        </div>
    @endforeach

    {{ $products->links() }}

    {{-- Modal --}}
    @if ($selectedProduct)
        <div
            x-data="{ open: true }"
            x-show="open"
            x-init="@this.on('open-modal', () => open = true)"
            class="fixed inset-0 bg-black/60 flex justify-center items-center z-50"
        >
            <div class="bg-white rounded-2xl shadow-xl p-6 max-w-lg w-full relative">
                <button
                    class="absolute top-2 right-2 text-gray-400 hover:text-gray-600"
                    @click="open = false"
                >&times;</button>

                <h2 class="text-2xl font-bold">{{ $selectedProduct->name }}</h2>
                <p class="text-sm text-gray-500 mb-2">Categoría: {{ $selectedProduct->category->name }}</p>
                <p class="text-gray-700 mb-4">{!! $selectedProduct->description !!}</p>
                <p><strong>Stock:</strong> {{ $selectedProduct->stock }}</p>
                <p><strong>Precio:</strong> ${{ number_format($selectedProduct->price, 2) }}</p>
            </div>
        </div>
    @endif
</div>
