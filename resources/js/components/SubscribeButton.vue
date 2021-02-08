<template>
    <button :class="classes" @click="subscribe">Subscribe</button>
</template>

<script>
    export default {
        name: "SubscribeButton",
        props: ['active'],
        computed: {
            classes() {
                return ['btn', this.active ? 'btn-danger' : 'btn-light']
            }
        },
        methods: {
            subscribe() {
                axios[(this.active ? 'delete' : 'post')](location.pathname + '/subscriptions');
                this.active = !this.active;
            }
        }
    }
</script>
