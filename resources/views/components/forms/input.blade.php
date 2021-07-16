<div {{ $attributes }}>
    <label for="field-{{ $name }}" class="form-label">{{ $label }}</label>
    <input v-model="book.{{ $name }}" name="{{ $name }}" type="{{ $type }}" class="form-control" :class="{'is-invalid': errorsValidation.{{ $name }}}" id="field-{{ $name }}" placeholder=" ">
    <div v-show="{{ $validation }}" class="invalid-feedback" v-html="{{ $validation }}"></div>
</div>
