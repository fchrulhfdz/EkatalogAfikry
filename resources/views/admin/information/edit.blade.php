@extends('layouts.admin')

@section('title', 'Edit Informasi - Afikry')

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Edit Informasi</h1>
                <p class="text-gray-600">Perbarui konten {{ $information->type }}</p>
            </div>
            <a href="{{ route('admin.information.index') }}" 
               class="bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-700 transition duration-300 flex items-center space-x-2">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>

        <!-- Edit Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('admin.information.update', $information) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul</label>
                        <input type="text" name="title" id="title" required
                               value="{{ old('title', $information->title) }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-afikry-primary focus:border-transparent text-lg">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Konten</label>
                        <textarea name="content" id="content" rows="12" required
                                  class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-afikry-primary focus:border-transparent resize-vertical"
                                  placeholder="Tulis konten informasi di sini...">{{ old('content', $information->content) }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        
                        @if($information->type === 'contact')
                        <p class="mt-2 text-sm text-gray-500">
                            Tips: Gunakan enter untuk membuat baris baru. Contoh format kontak:<br>
                            Alamat: Jl. Contoh No. 123<br>
                            Telepon: (021) 1234-5678<br>
                            Email: info@afikry.com
                        </p>
                        @endif
                    </div>

                    <!-- Preview -->
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <h3 class="font-semibold text-gray-800 mb-3">Preview:</h3>
                        <div class="prose max-w-none">
                            <h4 id="preview-title" class="text-xl font-bold text-gray-800">{{ $information->title }}</h4>
                            <div id="preview-content" class="text-gray-600 whitespace-pre-line mt-2">{{ $information->content }}</div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 pt-6 border-t">
                        <a href="{{ route('admin.information.index') }}" 
                           class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-400 transition duration-300">
                            Batal
                        </a>
                        <button type="submit" 
                                class="bg-afikry-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-afikry-secondary transition duration-300 flex items-center space-x-2">
                            <i class="fas fa-save"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.getElementById('title');
    const contentInput = document.getElementById('content');
    const previewTitle = document.getElementById('preview-title');
    const previewContent = document.getElementById('preview-content');

    function updatePreview() {
        previewTitle.textContent = titleInput.value;
        previewContent.textContent = contentInput.value;
    }

    titleInput.addEventListener('input', updatePreview);
    contentInput.addEventListener('input', updatePreview);
});
</script>
@endsection