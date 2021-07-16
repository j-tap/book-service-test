<div {{ $attributes }}>
    <label for="field-{{ $name }}" class="form-label">{{ $label }}</label>
    <textarea v-model="book.{{ $name }}" name="{{ $name }}" class="form-control" :class="{'is-invalid': errorsValidation.{{ $name }}}" id="field-{{ $name }}" placeholder=""></textarea>
    <div v-show="{{ $validation }}" class="invalid-feedback" v-html="{{ $validation }}"></div>
</div>
