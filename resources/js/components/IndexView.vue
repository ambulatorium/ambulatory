<script type="text/ecmascript-6">
    export default {
        props: [
            'resource', 'title'
        ],

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
            document.title = this.title + " — Ambulatory";

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
        <!-- header -->
        <div id="card-header" class="card-header d-flex align-items-center justify-content-between sticky-top">
            <h1>{{this.title}}</h1>

            <slot name="btn-new-entry"></slot>
        </div>

        <!-- loader -->
        <div v-if="!ready" class="d-flex align-items-center justify-content-center p-5">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div v-if="ready && entries.length == 0" class="p-5">
            <p class="text-center">No data were found</p>
        </div>

        <!-- content -->
        <div class="list-group list-group-flush" v-if="ready && entries.length > 0">
            <transition-group name="list">
                <div v-for="entry in entries" :key="entry.id">
                    <slot name="group-item" :entry="entry"></slot>
                </div>
            </transition-group>

            <div v-if="hasMoreEntries">
                <div class="text-center">
                    <a href="#" @click.prevent="loadOlderEntries" v-if="!loadingMoreEntries" class="list-group-item list-group-item-action">
                        Load Older Entries
                    </a>
                </div>

                <span v-if="loadingMoreEntries">Loading...</span>
            </div>
        </div>
    </div>
</template>