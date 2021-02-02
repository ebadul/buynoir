<template>
    <div id="category-links-template" class="category-links">
        <!-- categories list -->
        <nav
            :class="`category-links ${addClass ? addClass : ''}`"
            v-if="slicedCategories && slicedCategories.length > 0"
        >
            <ul class="nav d-flex justify-content-center" type="none">
                <li
                    :key="categoryIndex"
                    :id="`category-${category.id}`"
                    class="category-content pb-3 cursor-pointer"
                    v-for="(category, categoryIndex) in slicedCategories"
                    @mouseover="
                        toggleCategoryContainer(category, categoryIndex, true)
                    "
                    @mouseout="
                        toggleCategoryContainer(category, categoryIndex, false)
                    "
                >
                    <a
                        :href="`${$root.baseUrl}/${category.slug}`"
                        class="text-uppercase px-3 category unset"
                        :class="{'has-children': category.children.length &&
                                category.children.length > 0, 'is-active': showSub == categoryIndex}"
                        ref="link"
                    >
                        <div class="category-icon d-none" v-if="category.category_icon_path">
                            <img
                                class="d-none"
                                v-if="category.category_icon_path"
                                :src="
                                    `${$root.baseUrl}/storage/${category.category_icon_path}`
                                "
                            />
                        </div>

                        <span class="category-title">{{
                            category["name"]
                        }}</span>
                    </a>

                    <div
                        class="sub-category-container"
                        v-if="
                            category.children.length &&
                                category.children.length > 0
                        "
                        v-show="showSub == categoryIndex"
                    >
                        <div
                            :class="
                                `sub-categories sub-category-${sidebarLevel +
                                    categoryIndex} cursor-default`
                            "
                        >
                            <nav
                                :id="
                                    `links-level-${sidebarLevel +
                                        categoryIndex}`
                                "
                            >
                                <ul type="none">
                                    <li
                                        :key="
                                            `${subCategoryIndex}-${categoryIndex}`
                                        "
                                        v-for="(subCategory,
                                        subCategoryIndex) in category.children"
                                    >
                                        <a
                                            :id="
                                                `links-level-link-2-${subCategoryIndex}`
                                            "
                                            :href="
                                                `${$root.baseUrl}/${category.slug}/${subCategory.slug}`
                                            "
                                            class="category sub-category unset"
                                        >
                                            <div class="category-icon">
                                                <img
                                                    v-if="
                                                        subCategory.category_icon_path
                                                    "
                                                    :src="
                                                        `${$root.baseUrl}/storage/${subCategory.category_icon_path}`
                                                    "
                                                />
                                            </div>
                                            <span class="category-title">{{
                                                subCategory["name"]
                                            }}</span>
                                        </a>

                                        <ul type="none" class="nested">
                                            <li
                                                :key="
                                                    `${childSubCategoryIndex}-${subCategoryIndex}-${categoryIndex}`
                                                "
                                                v-for="(childSubCategory,
                                                childSubCategoryIndex) in subCategory.children"
                                            >
                                                <a
                                                    :id="
                                                        `links-level-link-3-${childSubCategoryIndex}`
                                                    "
                                                    class="category unset"
                                                    :href="
                                                        `${$root.baseUrl}/${category.slug}/${subCategory.slug}/${childSubCategory.slug}`
                                                    "
                                                >
                                                    <span
                                                        class="category-title"
                                                        >{{
                                                            childSubCategory.name
                                                        }}</span
                                                    >
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script type="text/javascript">
    export default {
        props: ["addClass", "parentSlug", "categoryCount"],

        data: function() {
            return {
                slicedCategories: [],
                sidebarLevel: Math.floor(Math.random() * 1000),
                showSub: null
            };
        },

        watch: {
            "$root.sharedRootCategories": function(categories) {
                this.formatCategories(categories);
            }
        },

        methods: {
            toggleCategoryContainer(category, index, shouldShow) {
                // @todo: Debounce / process in a better way to avoid
                // DOM calls
                if (this.showSub == index && shouldShow) return;
                if (
                    shouldShow &&
                    category.children &&
                    category.children.length > 0
                ) {
                    this.showSub = index;
                    document
                        .querySelector("body")
                        .classList.add("expanded-menu-on");
                } else {
                    document
                        .querySelector("body")
                        .classList.remove("expanded-menu-on");
                    this.showSub = null;
                }
            },

            formatCategories: function(categories) {
                let slicedCategories = categories;
                let categoryCount = this.categoryCount ? this.categoryCount : 9;

                if (slicedCategories && slicedCategories.length > categoryCount) {
                    slicedCategories = categories.slice(0, categoryCount);
                }

                if (this.parentSlug)
                    slicedCategories["parentSlug"] = this.parentSlug;

                this.slicedCategories = slicedCategories;
            }
        }
    };
</script>
