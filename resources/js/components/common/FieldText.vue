<template>
    <div class="w-full">
        <div class="font-medium mb-1" v-if="fieldTitle.length">
            {{ fieldTitle }}
        </div>
        <InputText class="w-full" @update:model-value="updateValue" :model-value="modelValue" :placeholder="fieldPlaceholder.length ? fieldPlaceholder : fieldTitle" />
    </div>
</template>
<script>
import InputText from 'primevue/inputtext';

export default {
    name: "FieldText",
    components: {
        InputText
    },
    props: {
        fieldTitle: {
            type: String,
            default: ''
        },
        modelValue: {
            type: String,
            default: ''
        },
        fieldPlaceholder: {
            type: String,
            default: ''
        }
    },
    methods: {
        updateValue(e) {
            this.$emit('update:modelValue', e)
        }
    }
}
</script>


