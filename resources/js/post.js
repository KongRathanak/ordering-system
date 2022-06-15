Vue.component('post-media', require('./components/PostMedia.vue').default);
Vue.component('post-small-media', require('./components/PostSmallMedia.vue').default);
Vue.component('post-card', require('./components/PostCard.vue').default);
Vue.component('category-card', require('./components/CategoryCard.vue').default);
new Vue({
    el: '#app_bro_bug',
    data() {
        return {
            slider_loaded: false,
            card_loaded: false,
            category_loaded: false,
            sliders: [
                {
                    category: 'Business',
                    date: 'July 2, 2020',
                    category_link: '#',
                    link: '#',
                    title: 'Your most unhappy customers are your greatest source of learning.',
                    content: 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.',
                    img: 'https://preview.colorlib.com/theme/magdesign/images/xpost_lg_4.jpg.pagespeed.ic.hSr_aHpE_J.webp',
                    user: {
                        name: '',
                        role: '',
                        img: ''
                    }
                },
            ],
            cards: [
                {
                    category: 'Business',
                    date: 'July 2, 2020',
                    category_link: '#',
                    link: '#',
                    title: 'Your most unhappy customers are your greatest source of learning.',
                    content: 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.',
                    img: 'https://preview.colorlib.com/theme/magdesign/images/xpost_lg_4.jpg.pagespeed.ic.hSr_aHpE_J.webp',
                    user: {
                        name: '',
                        role: 'Admin, 26 published post',
                        img: ''
                    }
                },
                {
                    category: 'Business',
                    date: 'July 2, 2020',
                    category_link: '#',
                    link: '#',
                    title: 'Your most unhappy customers are your greatest source of learning.',
                    content: 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.',
                    img: 'https://preview.colorlib.com/theme/magdesign/images/xpost_lg_4.jpg.pagespeed.ic.hSr_aHpE_J.webp',
                    user: {
                        name: '',
                        role: 'Admin, 26 published post',
                        img: ''
                    }
                },
                {
                    category: 'Business',
                    date: 'July 2, 2020',
                    category_link: '#',
                    link: '#',
                    title: 'Your most unhappy customers are your greatest source of learning.',
                    content: 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.',
                    img: 'https://preview.colorlib.com/theme/magdesign/images/xpost_lg_4.jpg.pagespeed.ic.hSr_aHpE_J.webp',
                    user: {
                        name: '',
                        role: 'Admin, 26 published post',
                        img: ''
                    }
                },
                {
                    category: 'Business',
                    date: 'July 2, 2020',
                    category_link: '#',
                    link: '#',
                    title: 'Your most unhappy customers are your greatest source of learning.',
                    content: 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.',
                    img: 'https://preview.colorlib.com/theme/magdesign/images/xpost_lg_4.jpg.pagespeed.ic.hSr_aHpE_J.webp',
                    user: {
                        name: '',
                        role: 'Admin, 26 published post',
                        img: ''
                    }
                },
                {
                    category: 'Business',
                    date: 'July 2, 2020',
                    category_link: '#',
                    link: '#',
                    title: 'Your most unhappy customers are your greatest source of learning.',
                    content: 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.',
                    img: 'https://preview.colorlib.com/theme/magdesign/images/xpost_lg_4.jpg.pagespeed.ic.hSr_aHpE_J.webp',
                    user: {
                        name: '',
                        role: 'Admin, 26 published post',
                        img: ''
                    }
                },
                {
                    category: 'Business',
                    date: 'July 2, 2020',
                    category_link: '#',
                    link: '#',
                    title: 'Your most unhappy customers are your greatest source of learning.',
                    content: 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.',
                    img: 'https://preview.colorlib.com/theme/magdesign/images/xpost_lg_4.jpg.pagespeed.ic.hSr_aHpE_J.webp',
                    user: {
                        name: '',
                        role: 'Admin, 26 published post',
                        img: ''
                    }
                },
                {
                    category: 'Business',
                    date: 'July 2, 2020',
                    category_link: '#',
                    link: '#',
                    title: 'Your most unhappy customers are your greatest source of learning.',
                    content: 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.',
                    img: 'https://preview.colorlib.com/theme/magdesign/images/xpost_lg_4.jpg.pagespeed.ic.hSr_aHpE_J.webp',
                    user: {
                        name: '',
                        role: 'Admin, 26 published post',
                        img: ''
                    }
                },
                {
                    category: 'Business',
                    date: 'July 2, 2020',
                    category_link: '#',
                    link: '#',
                    title: 'Your most unhappy customers are your greatest source of learning.',
                    content: 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.',
                    img: 'https://preview.colorlib.com/theme/magdesign/images/xpost_lg_4.jpg.pagespeed.ic.hSr_aHpE_J.webp',
                    user: {
                        name: '',
                        role: 'Admin, 26 published post',
                        img: ''
                    }
                },
                {
                    category: 'Business',
                    date: 'July 2, 2020',
                    category_link: '#',
                    link: '#',
                    title: 'Your most unhappy customers are your greatest source of learning.',
                    content: 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.',
                    img: 'https://preview.colorlib.com/theme/magdesign/images/xpost_lg_4.jpg.pagespeed.ic.hSr_aHpE_J.webp',
                    user: {
                        name: '',
                        role: 'Admin, 26 published post',
                        img: ''
                    }
                },
                {
                    category: 'Business',
                    date: 'July 2, 2020',
                    category_link: '#',
                    link: '#',
                    title: 'Your most unhappy customers are your greatest source of learning.',
                    content: 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.',
                    img: 'https://preview.colorlib.com/theme/magdesign/images/xpost_lg_4.jpg.pagespeed.ic.hSr_aHpE_J.webp',
                    user: {
                        name: '',
                        role: 'Admin, 26 published post',
                        img: ''
                    }
                },
            ],
            categories: [
                {
                    link: '#',
                    category: 'Sports',
                    articles: [
                        {
                            category: 'Business',
                            date: 'July 2, 2020',
                            category_link: '#',
                            link: '#',
                            title: 'Your most unhappy customers are your greatest source of learning.',
                            content: 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.',
                            img: 'https://preview.colorlib.com/theme/magdesign/images/xpost_lg_4.jpg.pagespeed.ic.hSr_aHpE_J.webp',
                            user: {
                                name: '',
                                role: 'Admin, 26 published post',
                                img: ''
                            }
                        },
                        {
                            category: 'Business',
                            date: 'July 2, 2020',
                            category_link: '#',
                            link: '#',
                            title: 'Your most unhappy customers are your greatest source of learning.',
                            content: 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.',
                            img: 'https://preview.colorlib.com/theme/magdesign/images/xpost_lg_4.jpg.pagespeed.ic.hSr_aHpE_J.webp',
                            user: {
                                name: '',
                                role: 'Admin, 26 published post',
                                img: ''
                            }
                        },
                        {
                            category: 'Business',
                            date: 'July 2, 2020',
                            category_link: '#',
                            link: '#',
                            title: 'Your most unhappy customers are your greatest source of learning.',
                            content: 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.',
                            img: 'https://preview.colorlib.com/theme/magdesign/images/xpost_lg_4.jpg.pagespeed.ic.hSr_aHpE_J.webp',
                            user: {
                                name: '',
                                role: 'Admin, 26 published post',
                                img: ''
                            }
                        },
                    ],
                },
                {
                    link: '#',
                    category: 'Sports',
                    articles: [
                        {
                            category: 'Business',
                            date: 'July 2, 2020',
                            category_link: '#',
                            link: '#',
                            title: 'Your most unhappy customers are your greatest source of learning.',
                            content: 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.',
                            img: 'https://preview.colorlib.com/theme/magdesign/images/xpost_lg_4.jpg.pagespeed.ic.hSr_aHpE_J.webp',
                            user: {
                                name: '',
                                role: 'Admin, 26 published post',
                                img: ''
                            }
                        },
                        {
                            category: 'Business',
                            date: 'July 2, 2020',
                            category_link: '#',
                            link: '#',
                            title: 'Your most unhappy customers are your greatest source of learning.',
                            content: 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.',
                            img: 'https://preview.colorlib.com/theme/magdesign/images/xpost_lg_4.jpg.pagespeed.ic.hSr_aHpE_J.webp',
                            user: {
                                name: '',
                                role: 'Admin, 26 published post',
                                img: ''
                            }
                        },
                        {
                            category: 'Business',
                            date: 'July 2, 2020',
                            category_link: '#',
                            link: '#',
                            title: 'Your most unhappy customers are your greatest source of learning.',
                            content: 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.',
                            img: 'https://preview.colorlib.com/theme/magdesign/images/xpost_lg_4.jpg.pagespeed.ic.hSr_aHpE_J.webp',
                            user: {
                                name: '',
                                role: 'Admin, 26 published post',
                                img: ''
                            }
                        },
                    ],
                },
            ]
        };
    },
    mounted() {
        this.getMakeRequest(`${this.app_url}/api/v1/articles/feature`)
            .then(({ data: { data } }) => {
                this.sliders = data;
                this.slider_loaded = true;
            })
            .catch(err => console.error(err));
        this.getMakeRequest(`${this.app_url}/api/v1/articles`, { per_page: 9 })
            .then(({ data: { data } }) => {
                this.cards = data;
                this.card_loaded = true;
            })
            .catch(err => console.error(err));
        this.getMakeRequest(`${this.app_url}/api/v1/categories`, {
            per_page: 2,
            with_articles: true,
        })
            .then(({ data: { data } }) => {
                this.categories = data;
                this.category_loaded = true;
            })
            .catch(err => console.error(err));
    }
});
