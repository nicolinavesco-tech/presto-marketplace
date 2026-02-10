<div>
  @if (session('status'))
  <div class="alert alert-success">
    {{ session('status') }}
  </div>
  @endif
  <div class="d-flex justify-content-center align-items-center py-5 formDiv">
    <form class="shadow-lg rounded p-2 my-2 create-article-form" wire:submit="save">
      <div class="mb-3">
        <label for="title" class="form-label text-dark">Titolo:</label>
        <input type="text" class="form-control form-control-sm @error('title') is-invalid @enderror" id="title" wire:model="title">
        @error('title')
        <p class="fst-italic text-danger">{{ $message }}</p>
        @enderror
      </div>
      <div class="mb-3">
        <label for="description" class="form-label text-dark">Descrizione</label>
        <textarea rows="4" class="textForm form-control form-control-lg @error('description') is-invalid @enderror" id="description" wire:model="description"></textarea>
        @error('description')
        <p class="fst-italic text-danger">{{ $message }}</p>
        @enderror
      </div>
      <div class="mb-3">
        <label for="price" class="form-label text-dark">Prezzo:</label>
        <input type="number" class="form-control form-control-sm @error('price') is-invalid @enderror" id="price" wire:model="price">
        @error('price')
        <p class="fst-italic text-danger">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-3 text-center">
        <select id="category" class="form-select form-select-sm custom-select @error('category') is-invalid @enderror" wire:model="category">
          <option label disabled>Seleziona una categoria</option>
          @foreach ($categories as $category)
          <option value="{{ $category->id }}">{{ $category->name }}</option>
          @endforeach
        </select>
        @error('category')
        <p class="fst-italic text-danger">{{ $message }}</p>
        @enderror
      </div>
      <div class="col-auto box-buttons">
        <button type="submit" class="mb-3 form-button w-50">Crea</button>
      </div>
    </form>
  </div>
</div>