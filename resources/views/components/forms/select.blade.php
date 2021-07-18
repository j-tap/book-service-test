<div {{ $attributes }}>
    <label for="field-{{ $name }}" class="form-label">{{ $label }}</label>
    <select v-model="{{ $value }}" name="{{ $name }}" class="form-select" :class="{'is-invalid': errorsValidation.{{ $name }}}" id="field-{{ $name }}" size="4" {{ $multiple }} placeholder=" ">
        <option v-for="item in {{ $items }}" :value="item.value" v-html="item.text"></option>
    </select>
    <div v-show="{{ $validation }}" class="invalid-feedback" v-html="{{ $validation }}"></div>
</div>
