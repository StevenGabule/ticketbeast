<template>
    <div>
        <button type="submit" :class="classes" @click="toggle">
            <span>Like</span>
            <span v-text="count"></span>
        </button>
    </div>
</template>

<script>
    export default {
        name: "Favorite",
        props: ['reply'],
        data() {
            return {
                count: this.reply.favoritesCount,
                active: this.reply.isFavorited,
            }
        },

        computed: {
            classes() {
                return ['btn btn-sm', this.active ? 'btn-primary' : 'btn-info']
            },
            endpoint() {
                return `/replies/${this.reply.id}/favorites`;
            },
        },

        methods: {
            toggle() {
                this.active ? this.destroy() : this.created();
            },
            destroy() {
                axios.delete(this.endpoint);
                this.active = false;
                this.count--;
            },
            created() {
                axios.post(this.endpoint);
                this.active = true;
                this.count++;
            }
        }
    }
</script>

