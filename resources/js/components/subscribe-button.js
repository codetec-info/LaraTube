import numeral from 'numeral'

Vue.component('subscribe-button', {

    props: {
        // will get the channel of the current user
        channel: {
            type: Object,
            required: true,
            default: () => ([])
        },

        initialSubscriptions: {
            type: Array,
            required: true,
            default: () => []
        },
    },

    data: function () {
        return {
            subscriptions: this.initialSubscriptions
        }
    },

    computed: {
        subscribed() {

            // If user not authenticated or the channel is for current logged user, then
            // do not allow subscribe/unsubscribe
            if (!__auth() || this.owner)
                return false

            // The !! will return boolean
            return !!this.subscription
        },

        owner() {
            return !!(__auth() && this.channel.user_id === __auth().id);
        },

        subscription() {
            if (!__auth())
                return null

            return this.subscriptions.find(subscription => subscription.user_id === __auth().id)
        },

        count() {
            // Format to million (1M), thousand (1K), ...
            return numeral(this.subscriptions.length).format('0a')
        }
    },

    methods: {
        toggleSubscription() {
            if (!__auth()) {
                return alert('Please login to subscribe.')
            }

            if (this.owner) {
                return alert('You cannot subscribe to your channel.')
            }

            if (this.subscribed) {
                axios.delete(`/channels/${this.channel.id}/subscriptions/${this.subscription.id}`)
                    .then(() => {
                        this.subscriptions = this.subscriptions.filter(s => s.id !== this.subscription.id)
                    })
            } else {
                axios.post(`/channels/${this.channel.id}/subscriptions`)
                    .then(response => {
                        this.subscriptions = [
                            // ... will spread all of the existing data and add the new
                            ...this.subscriptions,
                            response.data
                        ]
                    })
            }
        }
    }
})
