<script>
    import Replies from "../components/Replies";
    import SubscribeButton from "../components/SubscribeButton";

    export default {
        props: ['initialRepliesCount'],
        name: "Thread",
        components: {Replies, SubscribeButton},
        data() {
            return {
                repliesCount: this.initialRepliesCount
            }
        }
    }
</script>

