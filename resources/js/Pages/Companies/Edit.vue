<template>
    <PageWrapper
        header-pre-title="В этом разделе представлены настройки по компании. Общие настройки размещены в разделе «Функции и оплата»."
        :meta-title="company?.id ? `Редактирование ${company.name}` : 'Новая компания'"
        :header-title="company?.id ? company.name : 'Новая компания'"
    >

        <form @submit.prevent="submit">
            <Card class="pb-1 mb-3">
                <TextInput
                    v-model="form.name"
                    label-required
                    label="Название компании"
                    :invalid-text="form.errors.name"
                />
            </Card>

            <Card class="pb-1 mb-3">
                <h3 class="card-title">
                    Возможность оставить e-mail клиентом при отправке отзыва
                </h3>

                <p class="card-subtitle">
                    Дает возможность клиентам получить от вас ответ, а также вступить с вами в диалог.
                </p>

                <CheckboxSwitch
                    v-model="form.email_show"
                    label="Показать поле «e-mail»"
                />

                <CheckboxSwitch
                    v-model="form.email_required"
                    label="Сделать обязательным для заполнения"
                />
            </Card>

            <Card class="pb-1 mb-3">
                <h3 class="card-title">
                    Возможность оставить номер телефона клиентом при отправке отзыва
                </h3>

                <p class="card-subtitle">
                    Дает возможность удобно связаться с клиентом для уточнения информации в случае отрицательного отзыва.
                </p>

                <CheckboxSwitch
                    v-model="form.phone_show"
                    label="Показать поле «телефон»"
                />

                <div class="d-flex align-items-center">
                    <CheckboxSwitch
                        class="mt-2"
                        v-model="form.phone_required"
                        label="Сделать обязательным, если оценка отзыва меньше или равна"
                    />

                    <TextInput
                        style="width: 50px"
                        v-model="form.phone_required_review_gte_than"
                        type="number"
                        class="form-control form-control-sm mx-3"
                    />
                </div>
            </Card>

            <Card class="pb-1 mb-3">
                <h3 class="card-title">
                    Логотип компании
                </h3>

                <p class="card-subtitle">
                    При активации функции «Брендирование страницы отзыва» логотип вашей компании размещается на странице
                    отправки отзыва и в качестве аватара при ответе клиенту.
                </p>

                <Alert title="Формат изображения .jpg или .png" type="warning"/>

                <div class="avatar avatar-xl rounded-circle" :style="{backgroundImage: `url(${logoPreview || 'https://placehold.co/112'})`}"></div>

                <input type="file"
                       @input="onLogoChange"
                       ref="logo"
                       class="d-none" />

                <button type="button" class="btn btn-sm btn-info d-block mt-3" @click="$refs.logo.click()">Загрузить логотип</button>
            </Card>

            <!--        <Card class="pb-1 mb-3">
                        <h3 class="card-title">
                            Рекомендация клиенту продублировать положительный отзыв на публичные сервисы
                        </h3>

                        <p class="card-subtitle mb-4">
                            Мы автоматически копируем текст отзыва. Клиент кликает на один из указанных сервисов, происходит
                            автоматический переход. Клиент вставляет скопированный отзыв и нажимает кнопку «Отправить».
                        </p>

                        <CheckboxSwitch
                            v-model="form.phone_show"
                            label="Предоставляя подарок клиенту, вы значительно повышаете вероятность дублирования отзыва. Вероятность может составлять 30-70% в зависимости от подарка."
                        />

                        <div class="d-flex align-items-center mt-3">
                            <span>Минимальная оценка для предложения продублировать отзыв</span>

                            <TextInput
                                style="width: 50px"
                                type="number"
                                class="form-control form-control-sm mx-3"
                            />
                        </div>

                        <div class="mt-3">
                            Рекомендуем вставлять ссылки на раздел «Отзывы» либо страницу с написанием отзыва.
                        </div>

                        <div>
                            <label class="form-label mt-3">Yandex</label>

                            <div class="input-group mb-2">
                            <span class="input-group-text">
                              <input class="form-check-input m-0" type="checkbox" checked="">
                            </span>

                                <input type="text" class="form-control" autocomplete="off">
                            </div>
                        </div>

                        <div>
                            <label class="form-label mt-3">Google</label>

                            <div class="input-group mb-2">
                            <span class="input-group-text">
                              <input class="form-check-input m-0" type="checkbox" checked="">
                            </span>

                                <input type="text" class="form-control" autocomplete="off">
                            </div>
                        </div>

                        <div>
                            <label class="form-label mt-3">2Gis</label>

                            <div class="input-group mb-2">
                            <span class="input-group-text">
                              <input class="form-check-input m-0" type="checkbox" checked="">
                            </span>

                                <input type="text" class="form-control" autocomplete="off">
                            </div>
                        </div>

                        <div>
                            <label class="form-label mt-3">Tripadvisor</label>

                            <div class="input-group mb-2">
                            <span class="input-group-text">
                              <input class="form-check-input m-0" type="checkbox" checked="">
                            </span>

                                <input type="text" class="form-control" autocomplete="off">
                            </div>
                        </div>
                    </Card>-->

            <button class="btn btn-md btn-info">Сохранить</button>
        </form>
    </PageWrapper>
</template>

<script>
import {
    IconBlockquote,
    IconPlus,
} from "@tabler/icons-vue";
import {Link, useForm} from '@inertiajs/inertia-vue3'
import PageWrapper from "../../Shared/PageWrapper.vue";
import Card from "../../Shared/Card.vue";
import TextInput from "../../Shared/Form/TextInput.vue";
import CheckboxSwitch from "../../Shared/Form/CheckboxSwitch.vue";
import Alert from "../../Shared/Alert.vue";

export default {
    components: {Alert, CheckboxSwitch, TextInput, Card, IconBlockquote, PageWrapper, IconPlus},
    props: ['company'],
    data() {
        return {
            logoPreview: this.company?.logo_url,
            form: useForm({
                name: this.company?.name,
                email_show: this.company?.email_show !== undefined ? this.company?.email_show : true,
                email_required: this.company?.email_required !== undefined ? this.company?.email_required : false,
                phone_show: this.company?.phone_show !== undefined ? this.company?.phone_show : true,
                phone_required: this.company?.phone_required !== undefined ? this.company?.phone_required : false,
                phone_required_review_gte_than: this.company?.phone_required_review_gte_than || 3,
                logo: null
            })
        }
    },
    methods: {
        submit() {
            if (!this.company?.id) {
                this.form.post(route('companies.store'), {forceFormData: true});
                return;
            }

            this.form
                .transform(data => {
                    data['_method'] = 'put';
                    return data;
                })
                .post(route('companies.update', this.company.id), {forceFormData: true})
        },
        onLogoChange(e) {
            this.form.logo = e.target.files[0];
            this.logoPreview = URL.createObjectURL(this.form.logo);
        }
    }
}
</script>
