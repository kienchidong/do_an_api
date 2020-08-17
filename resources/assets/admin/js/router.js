import MasterLayout from "./layouts/MasterLayout";

/* page */
import test from "./pages/test";
import Home from "./pages/Home";
import AdminaccountList from "./pages/account/admins/AdminaccountList";
import CreateAdmin from "./pages/account/admins/CreateAdmin";
import CateNews from "./pages/news/CateNews";
import UserList from "./pages/account/users/UserList";
import CreateUser from "./pages/account/users/CreateUser";
import CreateNews from "./pages/news/CreateNews";
import ListNews from "./pages/news/ListNews";

/** questions */
import CreateQuestions from "./pages/exams/questions/CreateQuestions";
import ListSimpleQuestions from "./pages/exams/questions/ListSimpleQuestions";
import ListGroupQuestions from "./pages/exams/questions/ListGroupQuestions";
import EditGroupComponent from "./pages/exams/questions/EditGroupComponent";

/** video*/
import TypeVideo from "./pages/video/TypeVideo";
import ListVideo from "./pages/video/ListVideo";
import ListFeedBack from "./pages/feedback/ListFeedBack";
import ListResult from "./pages/result/ListResult";
import ListeningTest from "./pages/exams/Listen/ListeningTest"
import ListExams from "./pages/exams/ListExams";
import ListWriting from "./pages/exams/Write/ListWriting";
import CreateSynthetic from "./pages/exams/synthetic/CreateSynthetic";
import ListSynthetic from "./pages/exams/synthetic/ListSynthetic";

export const routes = [
    {
        path: "/",
        component: MasterLayout,
        redirect: "/dashboard",
        children: [
            {
                path: "dashboard",
                name: "router-name.home",
                component: Home,
                meta: {permissions: "all"}
            },
            {
                path: "testVue",
                name: "test",
                component: test,
                meta: {permissions: "all"}
            },
            {
                path: "adminAccount",
                name: "router-name.adminlist",
                component: AdminaccountList,
                meta: {permissions: "all"}
            },
            {
                path: "CreateAdmin",
                name: "account.admins.form.title",
                component: CreateAdmin,
                meta: {permissions: "all"}
            },
            {
                path: "cateNew",
                name: "router-name.catenews",
                component: CateNews,
                meta: {permissions: "all"}
            },
            {
                path: "User-List",
                name: "router-name.userList",
                component: UserList,
                meta: {permissions: "all"}

            },
            {
                path: "User-Create",
                name: "router-name.userCreate",
                component: CreateUser,
                meta: {permissions: "all"},
            },
            {
                path: "News-List",
                name: "router-name.newsList",
                component: ListNews,
                meta: {permissions: "all"}

            }, {
                path: "News-Create",
                name: "router-name.newsCreate",
                component: CreateNews,
                props: true,
                meta: {permissions: "all"}

            },
            {
                path: "List-Simple-Question",
                name: "router-name.questions.listSimple",
                component: ListSimpleQuestions,
                props: true,
                meta: {permissions: "all"}

            },{
                path: "List-Group-Question",
                name: "router-name.questions.listGroup",
                component: ListGroupQuestions,
                props: true,
                meta: {permissions: "all"}

            },{
                path: "List-Listening-Question.html",
                name: "router-name.questions.listen",
                component: ListeningTest,
                props: true,
                meta: {permissions: "all"}

            },{
                path: "Edit-Group-Question",
                name: "router-name.questions.editGroup",
                component: EditGroupComponent,
                props: true,
                meta: {permissions: "all"}

            },
            {
                path: "Questions-Create",
                name: "router-name.questionsCreate",
                component: CreateQuestions,
                props: true,
                meta: {permissions: "all"}

            },
            {
                path: "News-Edit/*",
                name: "router-name.newsEdit",
                component: CreateNews,
                props: true,
                meta: {permissions: "all"}

            },
            {
                path: "type-video.html",
                name: "router-name.typeVideo",
                component: TypeVideo,
                props: true,
                meta: {permissions: "all"}

            },
            {
                path: "list-video.html",
                name: "router-name.Video",
                component: ListVideo,
                props: true,
                meta: {permissions: "all"}

            },
            {
                path: "list-feedback.html",
                name: "router-name.Feedback",
                component: ListFeedBack,
                props: true,
                meta: {permissions: "all"}

            },
            {
                path: "list-result.html",
                name: "router-name.Result",
                component: ListResult,
                props: true,
                meta: {permissions: "all"}

            },
            {
                path: "List-Exams.html",
                name: "router-name.Exams",
                component: ListExams,
                props: true,
                meta: {permissions: "all"}

            },
            {
                path: "List-Writing.html",
                name: "router-name.questions.Writing",
                component: ListWriting,
                props: true,
                meta: {permissions: "all"}

            },
            {
                path: "List-Synthetic.html",
                name: "router-name.questions.Writing2",
                component: ListSynthetic,
                props: true,
                meta: {permissions: "all"}

            },
        ]
    }
];
