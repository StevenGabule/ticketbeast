<script>
    import Replies from "../components/Replies";

    export default {
        props: ['initialRepliesCount'],
        name: "Thread",
        components: {Replies},
        data() {
            return {
                repliesCount: this.initialRepliesCount
            }
        }
    }
</script>

