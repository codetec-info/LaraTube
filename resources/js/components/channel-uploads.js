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
        uploads: [],
        intervals: {},
    }),

    computed: {},

    methods: {
        upload() {
            this.selected = true;

            // Get array of files in order to be able to use map
            this.videos = Array.from(this.$refs.videos.files);

            // $.each() {}

            const uploaders = this.videos.map(video => {

                let formData = new FormData();

                this.progress[video.name] = 0;

                formData.append('video', video);
                formData.append('title', video.name);

                return axios.post(`/channels/${this.channel.id}/videos`, formData, {
                    headers: {'content-type': 'multipart/form-data'},

                    // will get the progress
                    onUploadProgress: (event) => {
                        this.progress[video.name] = Math.ceil((event.loaded / event.total) * 100);

                        // Force vue js to update once the progress has been changed
                        this.$forceUpdate()
                    }
                })
                    .then(({data}) => {
                        this.uploads = [
                            ...this.uploads,
                            data
                        ]

                    })
                    .catch(({error}) => {
                        console.log(error)
                    });
            });

            // To know when all uploads are done
            axios.all(uploaders)
                .then (()=> {
                    this.videos = this.uploads;

                    // Update video processing until it reach 100%
                    this.videos.forEach(video => {
                        this.intervals[video.id] = setInterval(() => {
                            axios.get(`/videos/${video.id}`)
                                .then(({data}) => {

                                    if(data.percentage === 100) {
                                        clearInterval(this.intervals[video.id])
                                    }

                                    this.videos = this.videos.map(v => {
                                        if(v.id === data.id)
                                            return data;
                                        return v
                                    })
                                })
                        }, 3000) // 3000 = 3 seconds
                    })
                })
        },
    }
});
