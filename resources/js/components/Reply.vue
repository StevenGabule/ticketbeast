<template>
    <div class="card mb-3 mt-3" :id="'reply-'+id">

        <div class="card-header">
            <div class="level">
                <h5 class="flex">
                    <a :href="'/profiles/'+data.owner.name" v-text="data.owner.name"></a>
                    said {{ data.created_at }}
                </h5>
                <div v-if="signedIn">
                    <favorite :reply="data"></favorite>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control form-control-sm" name="body" v-model="body"></textarea>
                </div>
                <button class="btn btn-sm btn-primary" @click="update">Update</button>
                <button class="btn btn-sm btn-dark" @click="editing = false">Cancel</button>
            </div>
            <div v-else v-text="body"></div>
        </div>

        <div class="card-footer" v-if="canUpdate">
            <div class="d-flex">
                <button class="btn-info btn btn-sm" @click="editing = true">Edit</button>
                <button @click="destroy" class="btn btn-sm btn-danger ml-2">Delete</button>
            </div>
        </div>
    </div>


</template>

<script>
    import Favorite from "./Favorite";

    export default {
        name: "Reply",
        props: ['data'],
        components: {Favorite},
        data() {
            return {
                editing: false,
                id: this.data.id,
                body: this.data.body
            }
        },

        computed: {
            signedIn() {
                return window.App.signedIn;
            },
            canUpdate() {
               return this.authorize(user => this.data.user_id === user.id);
                // return this.data.user_id === window.App.user.id;
            },
        },

        methods: {
            update() {
                axios.patch(`/replies/${this.data.id}`, {
                    body: this.body
                })
                this.editing = false;
                flash('Updated reply!');
            },
            destroy() {
                axios.delete(`/replies/${this.data.id}`);
                this.$emit('deleted', this.data.id);
            }
        }
    }
</script>
