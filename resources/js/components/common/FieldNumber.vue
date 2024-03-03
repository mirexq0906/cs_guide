<template>
    <div class="w-full">
        <div class="font-medium mb-1" v-if="fieldTitle.length">
            {{ fieldTitle }}
        </div>
        <InputNumber class="w-full" @update:model-value="updateValue" :model-value="modelValue"/>
    </div>
</template>
<script>
import InputNumber from 'primevue/inputnumber';

export default {
    name: "FieldText",
    components: {
        InputNumber
    },
    props: {
        fieldTitle: {
            type: String,
            default: ''
        },
        modelValue: {
            type: Number,
            default: 0
        },
    },
    methods: {
        updateValue(e) {
            this.$emit('update:modelValue', e)
        }
    }
}
</script>


