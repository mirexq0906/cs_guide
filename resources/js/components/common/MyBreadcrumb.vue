<template>
    <Breadcrumb class="mb-2" :home="home" :model="dataBreadcrumb">
        <template #item="{ item, props }">
            <router-link v-if="item.route" v-slot="{ href, navigate }" :to="item.route" custom>
                <a :href="href" v-bind="props.action" @click="navigate">
                    <span :class="[item.icon, 'text-color']" />
                    <span class="text-primary font-semibold">{{ item.label }}</span>
                </a>
            </router-link>
            <a v-else :href="item.url" :target="item.target" v-bind="props.action">
                <span class="text-color">{{ item.label }}</span>
            </a>
        </template>
    </Breadcrumb>
</template>
<script>
import Breadcrumb from 'primevue/breadcrumb';

export default {
    name: "MyBreadcrumb",
    components: {
        Breadcrumb
    },
    props: {
        dataBreadcrumb: {
            type: Array,
            default: () => []
        }
    },
    data() {
        return {
            home: {
                icon: 'pi pi-home',
                route: '/'
            },
            items: [
                { label: 'Components' },
                { label: 'Form' },
                { label: 'InputText', route: '/inputtext' }
            ]
        }
    }
}
</script>
