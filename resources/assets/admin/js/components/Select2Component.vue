<template>
    <div class="root">
        <select>
            <slot></slot>
        </select>
    </div>
</template>

<script>
    export default {
        name: "Select2Component",
        props: ['options', 'value'],
        mounted: function () {
            var vm = this
            $(this.$el)
                .val(this.value)
                // init select2
                .select2({ data: this.options })
                // emit event on change.
                .on('change', function () {
                    vm.$emit('input', this.value)
                })
        },
        watch: {
            value: function (value) {
                // update value
                $(this.$el).select2('val', value)
            },
            options: function (options) {
                // update options
                $(this.$el).select2({ data: options })
            }
        },
        destroyed: function () {
            $(this.$el).off().select2('destroy')
        }
    }
</script>

<style scoped>

</style>
