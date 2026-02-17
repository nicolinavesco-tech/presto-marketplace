<div>
  @if (session('status'))
  <div class="alert alert-warning text-center">
    {{ session('status') }}
  </div>
  @endif
  <div class="d-flex justify-content-center align-items-center py-5 formDiv">
    <form class="shadow-lg rounded p-2 my-2 create-article-form" wire:submit="store">

      <div class="mb-3">
        <label for="title" class="form-label text-dark">{{ __('ui.fieldTitle') }}</label>
        <input type="text" class="form-control form-control-sm @error('title') is-invalid @enderror" id="title" wire:model="title">
        @error('title')
        <p class="fst-italic text-danger">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-3">
        <label for="description" class="form-label text-dark">{{ __('ui.fieldDescription') }}</label>
        <textarea rows="4" class="textForm form-control form-control-lg @error('description') is-invalid @enderror" id="description" wire:model="description"></textarea>
        @error('description')
        <p class="fst-italic text-danger">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-3">
        <label for="price" class="form-label text-dark">{{ __('ui.fieldPrice') }}</label>
        <input type="number" class="form-control form-control-sm @error('price') is-invalid @enderror" id="price" wire:model="price">
        @error('price')
        <p class="fst-italic text-danger">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-3">
        <input type="file"
          wire:model="temporary_images"
          multiple
          class="form-control shadow @error('temporary_images.*') is-invalid @enderror"
          placeholder="img/">
        @error('temporary_images.*')
        <p class="fst-italic text-danger">{{ $message }}</p>
        @enderror
      </div>

      @if (!empty($images))
      <div class="row rounded shadow py-4">
        @foreach ($images as $key => $image)
        <div class="col-6 col-md-4 d-flex flex-column align-items-center my-3">
          <div class="img-preview mx-auto shadow rounded"
            style="background-image: url({{ $image->temporaryUrl() }});">
          </div>
          <button type="button"
            class="btn btn-danger btn-sm mt-2"
            wire:click="removeImage({{ $key }})">
            X
          </button>
        </div>
        @endforeach
      </div>
      @endif

      <div class="mb-3 text-center">
        <select id="category"
          class="form-select form-select-sm custom-select @error('category') is-invalid @enderror"
          wire:model="category">
          <option label disabled>{{ __('ui.chooseCategory') }}</option>
          @foreach ($categories as $category)
          <option value="{{ $category->id }}">{{ $category->name }}</option>
          @endforeach
        </select>
        @error('category')
        <p class="fst-italic text-danger">{{ $message }}</p>
        @enderror
      </div>

      <div class="col-auto box-buttons">
        <button type="submit" class="mb-3 form-button w-50">{{ __('ui.createAction') }}</button>
      </div>

    </form>
  </div>
</div>