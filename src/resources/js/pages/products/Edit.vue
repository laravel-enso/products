<template>
    <div class="columns is-centered">
        <div class="column is-three-quarters-desktop is-full-touch">
            <enso-form class="box form-box has-background-light raises-on-hover"
                ref="form"
                @loaded="init()">
                <template v-slot:suppliers="{ field }">
                    <form-field :field="field"
                        @input="selectedSuppliers.id = $event"
                        ref="suppliers"/>
                </template>
                <template v-slot:defaultSupplierId="{ field }">
                    <form-field :field="field"
                        :params="selectedSuppliers"
                        ref="defaultSupplier"/>
                </template>
            </enso-form>
        </div>
    </div>
</template>

<script>
import { EnsoForm, FormField } from '@enso-ui/bulma';

export default {
    name: 'Edit',

    components: { EnsoForm, FormField },

    data: () => ({
        selectedSuppliers: { id: [] },
    }),

    methods: {
        init() {
            this.selectedSuppliers.id = this.$refs.form.field('suppliers').value;
        },
    },
};
</script>

<style lang="scss">
</style>
