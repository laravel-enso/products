<template>
    <div class="columns is-centered">
        <div class="column is-three-quarters-desktop is-full-touch">
            <enso-form class="box form-box has-background-light raises-on-hover">
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
    name: 'Create',

    components: { EnsoForm, FormField },

    data: () => ({
        selectedSuppliers: { id: [] },
    }),
};
</script>

<style lang="scss">
</style>
