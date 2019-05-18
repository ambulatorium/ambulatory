<script type="text/ecmascript-6">
    export default {}
</script>

<template>
    <form-entry title="Specialization" resource="specializations" okToSave okToDelete>
        <template slot="entry-data" slot-scope="slotProps">
            <div class="form-group row">
                <label for="name" class="col-sm-4 col-form-label text-md-right font-weight-bold">Name</label>

                <div class="col-sm-6">
                    <input id="name"
                        type="text"
                        class="form-control form-control-lg bg-light border-0"
                        v-model="slotProps.formData.name"
                        autofocus>

                    <form-errors :errors="slotProps.formErrors.name"></form-errors>
                </div>
            </div>

            <div class="form-group row">
                <label for="description" class="col-sm-4 col-form-label text-md-right font-weight-bold">Description</label>

                <div class="col-sm-6">
                    <input id="description"
                        type="text"
                        class="form-control form-control-lg bg-light border-0"
                        v-model="slotProps.formData.description">

                    <form-errors :errors="slotProps.formErrors.description"></form-errors>
                </div>
            </div>
        </template>
    </form-entry>
</template>