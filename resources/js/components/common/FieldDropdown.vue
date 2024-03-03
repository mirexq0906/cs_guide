<template>
    <div class="w-full">
        <div class="font-medium mb-1" v-if="fieldTitle.length">
            {{ fieldTitle }}
        </div>
        <Dropdown @update:modelValue="setRecord" :model-value="selected" :options="fieldData" filter :optionLabel="fieldLabel" :placeholder="fieldPlaceholder"
                  class="w-full">
            <template #value="slotProps">
                <div v-if="slotProps.value">
                    {{ slotProps.value.name }}
                </div>
                <span v-else>
                    {{ slotProps.placeholder }}
                </span>
            </template>
            <template #option="slotProps">
                <div>{{ slotProps.option.name }}</div>
            </template>
        </Dropdown>
    </div>
</template>
<script>
import Dropdown from 'primevue/dropdown';

export default {
    name: "FieldDropdown",
    components: {
        Dropdown
    },
    emits: ['update:modelValue', 'updateDropdown'],
    props: {
        fieldData: {
            type: Array,
            default: () => []
        },
        fieldPlaceholder: {
            type: String,
            default: ''
        },
        fieldLabel: {
            type: String,
            default: ''
        },
        fieldValue: {
            type: String,
            default: ''
        },
        fieldTitle: {
            type: String,
            default: ''
        },
        modelValue: {
            default: null
        }
    },
    data() {
        return {
            selected: null,
            count: 0,
        };
    },
    watch: {
        modelValue(newValue) {
            if(newValue == null) {
                this.selected = null
            }
            this.setFirstRecord()
        },
        fieldData() {
            this.setFirstRecord()
        }
    },
    methods: {
        setRecord(e) {
            this.selected = e
            this.$emit('update:modelValue', e[this.fieldValue])
            this.$emit('updateDropdown')
        },
        setFirstRecord() {
            if(!this.selected) {
                this.selected = this.fieldData.find(item => item.id === this.modelValue) ?? null
            }
        }
    }
}
</script>


