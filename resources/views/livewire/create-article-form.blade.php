<div>
  <form>
    <div class="mb-3 mt-5">
      <label for="title" class="form-label">Titolo:</label>
      <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" wire:model="title">
      @error('title')
      <p class="fst-italic text-danger">{{ $message }}</p>
      @enderror
    </div>
    <div class="mb-3">
      <label for="description" class="form-label">Descrizione</label>
      <textarea class="form-control @error('description') is-invalid @enderror" id="description" wire:model="description"></textarea>
      @error('description')
      <p class="fst-italic text-danger">{{ $message }}</p>
      @enderror
    </div>
    <div class="mb-3">
      <label for="price" class="form-label">Prezzo:</label>
      <input type="text" class="form-control @error('price') is-invalid @enderror" id="price" wire:model="price">
      @error('price')
      <p class="fst-italic text-danger">{{ $message }}</p>
      @enderror
    </div>

    <div class="mb-3">
      <select id="category" class="@error('category') is-invalid @enderror" wire:model="category" >
        <option label disabled>Seleziona una categoria</option>
        @foreach ($categories as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
      </select>
      @error('category')
      <p class="fst-italic text-danger">{{ $message }}</p>
      @enderror
    </div>
    <div class="d-flex justify-content-center">
      <button type="submit" class="btn btn-primary">Crea</button>
    </div>
  </form>
</div>