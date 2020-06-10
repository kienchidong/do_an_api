<template>
    <div class="root">
        <section class="content">

            <!-- SELECT2 EXAMPLE -->
            <div class="box box-default">
                <div class="box-header with-border">

                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <b-tabs content-class="mt-3" justified align="center">
                        <b-tab title="Simple" active>
                            <simple-question :action="true" />
                        </b-tab>
                        <b-tab title="Group" >
                            <group-questions />
                        </b-tab>
                    </b-tabs>
                </div>

            </div>
        </section>
    </div>
</template>

<script>
    import SimpleQuestion from "./SimpleQuestion";
    import GroupQuestions from "./GroupQuestions";


    export default {
        name: "CreateQuestions",
        components:{
            SimpleQuestion,
            GroupQuestions
        }
    }
</script>

<style scoped>

</style>
