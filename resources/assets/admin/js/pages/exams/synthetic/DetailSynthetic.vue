<template>
    <div class="root">
        <b-container class="bv-example-row">
            <b>{{ questionDetail.name }}</b>
            <hr>
            <audio controls v-if="questionDetail.audio">
                <source :src="questionDetail.audio" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>

            <b-row>
                <b-col sm="12" md="12">
                    <b-form inline>
                        <p v-html="questionDetail.describe"></p>
                    </b-form>
                </b-col>
                <hr>
                <b-col v-for="(question, indexQuestions) in questionDetail.questions"
                       :key="indexQuestions" sm="12"
                       md="6" align="left">
                    <b>{{indexQuestions+1}}: {{ question.question}}</b><br>
                    <img v-if="question.image != 0" :src="question.image" width="50%" alt="">
                    <b-row>
                        <b-col v-for="(item, index) in question.answers" :key="index" sm="12"
                               md="6">
                            <b-form inline>
                                <label class="mr-sm-2">
                                    {{ questionLabel[index] }}: {{ item.answer }}
                                </label><i v-if="item.status"
                                           class="fa fa-check text-green"></i>
                            </b-form>
                        </b-col>
                    </b-row>
                </b-col>
            </b-row>
        </b-container>
    </div>

</template>

<script>
    const questionLabel = [
        'A',
        'B',
        'C',
        'D'
    ];
    export default {
        name: "DetailSynthetic",
        props:['questionDetail'],
        data() {
            return {
                questionLabel: [...questionLabel]
            }
        },
    }
</script>

<style scoped>

</style>
