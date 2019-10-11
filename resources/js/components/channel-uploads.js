Vue.component('channel-uploads', {

    props: {
        channel: {
            type: Object,
            required: true,
            default: () => ({}) // empty object
        }
    },

    data: () => ({
        selected: false,
        videos: [],
        progress: {},
    }),

    computed: {},

    methods: {
        upload() {
            // console.log(this.$refs)
            this.selected = true

            // Get array of files in order to be able to use map
            this.videos = Array.from(this.$refs.videos.files)

            // $.each() {}

            this.videos.map(video => {

                let formData = new FormData()

                this.progress[video.name] = 0

                formData.append('video', video)
                formData.append('title', video.name)

                return axios.post(`/channels/${this.channel.id}/videos`, formData, {
                    headers: {'content-type': 'multipart/form-data'},

                    // will get the progress
                    onUploadProgress: (event) => {
                         this.progress[video.name] = Math.ceil((event.loaded / event.total) * 100)

                        // Force vue js to update once the progress has been changed
                        this.$forceUpdate()
                    }
                })
                    .then(function (response) {
                        // console.log(response.data)
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            })

        },
    }
})
