<template>
    <div>
        <div v-if="signedIn">

            <div class="form-group">
            <textarea
                name="body"
                id="body"
                class="form-control"
                required
                placeholder="Leave a comment"
                rows="5" v-model="body"></textarea>
            </div>
            <button class="btn btn-success btn-sm" type="submit" @click="addReply">Submit</button>
        </div>
        <p class="text-center" v-else>
            Please <a href="/login">sign in</a> to participate in this
            discussion. </p>
    </div>
</template>

<script>
    export default {
        props: ['endpoint'],
        name: "NewReply",
        data() {
            return {
                body: '',
                endpoint: this.endpoint
            }
        },

        computed: {
            signedIn() {
                return window.App.signedIn;
            }
        },

        methods: {
            addReply() {
                axios.post(this.endpoint, {body: this.body})
                    .then(({data}) => {
                        this.body = '';
                        flash("Your reply has been posted.")
                        this.$emit('created', data)
                    });
            },
        }
    }
</script>
