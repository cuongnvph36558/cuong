import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Admin\FeedbackController::index
 * @see app/Http/Controllers/Admin/FeedbackController.php:23
 * @route '/admin/feedbacks'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/feedbacks',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\FeedbackController::index
 * @see app/Http/Controllers/Admin/FeedbackController.php:23
 * @route '/admin/feedbacks'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\FeedbackController::index
 * @see app/Http/Controllers/Admin/FeedbackController.php:23
 * @route '/admin/feedbacks'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\FeedbackController::index
 * @see app/Http/Controllers/Admin/FeedbackController.php:23
 * @route '/admin/feedbacks'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\FeedbackController::index
 * @see app/Http/Controllers/Admin/FeedbackController.php:23
 * @route '/admin/feedbacks'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\FeedbackController::index
 * @see app/Http/Controllers/Admin/FeedbackController.php:23
 * @route '/admin/feedbacks'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\FeedbackController::index
 * @see app/Http/Controllers/Admin/FeedbackController.php:23
 * @route '/admin/feedbacks'
 */
        indexForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    index.form = indexForm
/**
* @see \App\Http\Controllers\Admin\FeedbackController::create
 * @see app/Http/Controllers/Admin/FeedbackController.php:56
 * @route '/admin/feedbacks/create'
 */
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/admin/feedbacks/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\FeedbackController::create
 * @see app/Http/Controllers/Admin/FeedbackController.php:56
 * @route '/admin/feedbacks/create'
 */
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\FeedbackController::create
 * @see app/Http/Controllers/Admin/FeedbackController.php:56
 * @route '/admin/feedbacks/create'
 */
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\FeedbackController::create
 * @see app/Http/Controllers/Admin/FeedbackController.php:56
 * @route '/admin/feedbacks/create'
 */
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\FeedbackController::create
 * @see app/Http/Controllers/Admin/FeedbackController.php:56
 * @route '/admin/feedbacks/create'
 */
    const createForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: create.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\FeedbackController::create
 * @see app/Http/Controllers/Admin/FeedbackController.php:56
 * @route '/admin/feedbacks/create'
 */
        createForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: create.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\FeedbackController::create
 * @see app/Http/Controllers/Admin/FeedbackController.php:56
 * @route '/admin/feedbacks/create'
 */
        createForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: create.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    create.form = createForm
/**
* @see \App\Http\Controllers\Admin\FeedbackController::store
 * @see app/Http/Controllers/Admin/FeedbackController.php:66
 * @route '/admin/feedbacks'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/feedbacks',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Admin\FeedbackController::store
 * @see app/Http/Controllers/Admin/FeedbackController.php:66
 * @route '/admin/feedbacks'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\FeedbackController::store
 * @see app/Http/Controllers/Admin/FeedbackController.php:66
 * @route '/admin/feedbacks'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Admin\FeedbackController::store
 * @see app/Http/Controllers/Admin/FeedbackController.php:66
 * @route '/admin/feedbacks'
 */
    const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: store.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\FeedbackController::store
 * @see app/Http/Controllers/Admin/FeedbackController.php:66
 * @route '/admin/feedbacks'
 */
        storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: store.url(options),
            method: 'post',
        })
    
    store.form = storeForm
/**
* @see \App\Http\Controllers\Admin\FeedbackController::edit
 * @see app/Http/Controllers/Admin/FeedbackController.php:77
 * @route '/admin/feedbacks/{feedback}/edit'
 */
export const edit = (args: { feedback: number | { id: number } } | [feedback: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/admin/feedbacks/{feedback}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\FeedbackController::edit
 * @see app/Http/Controllers/Admin/FeedbackController.php:77
 * @route '/admin/feedbacks/{feedback}/edit'
 */
edit.url = (args: { feedback: number | { id: number } } | [feedback: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { feedback: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { feedback: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    feedback: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        feedback: typeof args.feedback === 'object'
                ? args.feedback.id
                : args.feedback,
                }

    return edit.definition.url
            .replace('{feedback}', parsedArgs.feedback.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\FeedbackController::edit
 * @see app/Http/Controllers/Admin/FeedbackController.php:77
 * @route '/admin/feedbacks/{feedback}/edit'
 */
edit.get = (args: { feedback: number | { id: number } } | [feedback: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\FeedbackController::edit
 * @see app/Http/Controllers/Admin/FeedbackController.php:77
 * @route '/admin/feedbacks/{feedback}/edit'
 */
edit.head = (args: { feedback: number | { id: number } } | [feedback: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\FeedbackController::edit
 * @see app/Http/Controllers/Admin/FeedbackController.php:77
 * @route '/admin/feedbacks/{feedback}/edit'
 */
    const editForm = (args: { feedback: number | { id: number } } | [feedback: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: edit.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\FeedbackController::edit
 * @see app/Http/Controllers/Admin/FeedbackController.php:77
 * @route '/admin/feedbacks/{feedback}/edit'
 */
        editForm.get = (args: { feedback: number | { id: number } } | [feedback: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: edit.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\FeedbackController::edit
 * @see app/Http/Controllers/Admin/FeedbackController.php:77
 * @route '/admin/feedbacks/{feedback}/edit'
 */
        editForm.head = (args: { feedback: number | { id: number } } | [feedback: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: edit.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    edit.form = editForm
/**
* @see \App\Http\Controllers\Admin\FeedbackController::update
 * @see app/Http/Controllers/Admin/FeedbackController.php:87
 * @route '/admin/feedbacks/{feedback}'
 */
export const update = (args: { feedback: number | { id: number } } | [feedback: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/admin/feedbacks/{feedback}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Admin\FeedbackController::update
 * @see app/Http/Controllers/Admin/FeedbackController.php:87
 * @route '/admin/feedbacks/{feedback}'
 */
update.url = (args: { feedback: number | { id: number } } | [feedback: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { feedback: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { feedback: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    feedback: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        feedback: typeof args.feedback === 'object'
                ? args.feedback.id
                : args.feedback,
                }

    return update.definition.url
            .replace('{feedback}', parsedArgs.feedback.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\FeedbackController::update
 * @see app/Http/Controllers/Admin/FeedbackController.php:87
 * @route '/admin/feedbacks/{feedback}'
 */
update.put = (args: { feedback: number | { id: number } } | [feedback: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

    /**
* @see \App\Http\Controllers\Admin\FeedbackController::update
 * @see app/Http/Controllers/Admin/FeedbackController.php:87
 * @route '/admin/feedbacks/{feedback}'
 */
    const updateForm = (args: { feedback: number | { id: number } } | [feedback: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: update.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'PUT',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\FeedbackController::update
 * @see app/Http/Controllers/Admin/FeedbackController.php:87
 * @route '/admin/feedbacks/{feedback}'
 */
        updateForm.put = (args: { feedback: number | { id: number } } | [feedback: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: update.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'PUT',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    update.form = updateForm
/**
* @see \App\Http\Controllers\Admin\FeedbackController::destroy
 * @see app/Http/Controllers/Admin/FeedbackController.php:98
 * @route '/admin/feedbacks/{feedback}'
 */
export const destroy = (args: { feedback: number | { id: number } } | [feedback: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/admin/feedbacks/{feedback}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Admin\FeedbackController::destroy
 * @see app/Http/Controllers/Admin/FeedbackController.php:98
 * @route '/admin/feedbacks/{feedback}'
 */
destroy.url = (args: { feedback: number | { id: number } } | [feedback: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { feedback: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { feedback: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    feedback: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        feedback: typeof args.feedback === 'object'
                ? args.feedback.id
                : args.feedback,
                }

    return destroy.definition.url
            .replace('{feedback}', parsedArgs.feedback.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\FeedbackController::destroy
 * @see app/Http/Controllers/Admin/FeedbackController.php:98
 * @route '/admin/feedbacks/{feedback}'
 */
destroy.delete = (args: { feedback: number | { id: number } } | [feedback: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

    /**
* @see \App\Http\Controllers\Admin\FeedbackController::destroy
 * @see app/Http/Controllers/Admin/FeedbackController.php:98
 * @route '/admin/feedbacks/{feedback}'
 */
    const destroyForm = (args: { feedback: number | { id: number } } | [feedback: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: destroy.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'DELETE',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\FeedbackController::destroy
 * @see app/Http/Controllers/Admin/FeedbackController.php:98
 * @route '/admin/feedbacks/{feedback}'
 */
        destroyForm.delete = (args: { feedback: number | { id: number } } | [feedback: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: destroy.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'DELETE',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    destroy.form = destroyForm
/**
* @see \App\Http\Controllers\Admin\FeedbackController::uploadImage
 * @see app/Http/Controllers/Admin/FeedbackController.php:108
 * @route '/admin/feedbacks/upload'
 */
export const uploadImage = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: uploadImage.url(options),
    method: 'post',
})

uploadImage.definition = {
    methods: ["post"],
    url: '/admin/feedbacks/upload',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Admin\FeedbackController::uploadImage
 * @see app/Http/Controllers/Admin/FeedbackController.php:108
 * @route '/admin/feedbacks/upload'
 */
uploadImage.url = (options?: RouteQueryOptions) => {
    return uploadImage.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\FeedbackController::uploadImage
 * @see app/Http/Controllers/Admin/FeedbackController.php:108
 * @route '/admin/feedbacks/upload'
 */
uploadImage.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: uploadImage.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Admin\FeedbackController::uploadImage
 * @see app/Http/Controllers/Admin/FeedbackController.php:108
 * @route '/admin/feedbacks/upload'
 */
    const uploadImageForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: uploadImage.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\FeedbackController::uploadImage
 * @see app/Http/Controllers/Admin/FeedbackController.php:108
 * @route '/admin/feedbacks/upload'
 */
        uploadImageForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: uploadImage.url(options),
            method: 'post',
        })
    
    uploadImage.form = uploadImageForm
const FeedbackController = { index, create, store, edit, update, destroy, uploadImage }

export default FeedbackController