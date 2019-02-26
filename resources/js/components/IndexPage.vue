<script type="text/ecmascript-6">
    export default {
        props: [
            'resource', 'title'
        ],

        /**
         * The component's data.
         */
        data() {
            return {
                entries: [],
                ready: false,
                nextPageUrl: null,
                hasMoreEntries: false,
                loadingMoreEntries: false
            }
        },

        mounted() {
            document.title = this.title + " — Reliqui";

            this.loadEntries();
        },

        methods: {
            loadEntries() {
                this.http().get('/api/' + this.resource).then(response => {
                    this.entries = response.data.entries.data;

                    this.hasMoreEntries = !!response.data.entries.next_page_url;

                    this.nextPageUrl = response.data.entries.next_page_url;

                    this.ready = true;
                });
            },

            loadOlderEntries() {
                this.loadingMoreEntries = true;

                this.http().get(this.nextPageUrl).then(response => {
                    this.entries.push(...response.data.entries.data);

                    this.hasMoreEntries = !!response.data.entries.next_page_url;

                    this.nextPageUrl = response.data.entries.next_page_url;

                    this.loadingMoreEntries = false;
                });
            }
        }
    }
</script>

<template>
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h1>{{this.title}}</h1>

            <slot name="store-resource"></slot>
        </div>

        <div v-if="!ready" class="d-flex align-items-center justify-content-center p-5">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div v-if="ready && entries.length == 0" class="p-5">
            <p class="text-center">No data were found</p>
        </div>

        <table id="indexPage" class="table table-hover table-sm mb-0" v-if="ready && entries.length > 0">
            <thead>
                <slot name="table-header"></slot>
            </thead>

            <transition-group tag="tbody" name="list">
                <tr v-for="entry in entries" :key="entry.id">
                    <slot name="table-row" :entry="entry"></slot>
                </tr>

                <tr v-if="hasMoreEntries" key="olderEntries">
                    <td colspan="100" class="text-center py-1">
                        <small>
                            <a href="#" v-on:click.prevent="loadOlderEntries" v-if="!loadingMoreEntries">
                                Load Older Pages
                            </a>
                        </small>

                        <small v-if="loadingMoreEntries">Loading...</small>
                    </td>
                </tr>
            </transition-group>
        </table>
    </div>
</template>