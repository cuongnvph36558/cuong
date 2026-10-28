import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Admin\HomeContentController::edit
 * @see app/Http/Controllers/Admin/HomeContentController.php:20
 * @route '/admin/home-content'
 */
export const edit = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/admin/home-content',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\HomeContentController::edit
 * @see app/Http/Controllers/Admin/HomeContentController.php:20
 * @route '/admin/home-content'
 */
edit.url = (options?: RouteQueryOptions) => {
    return edit.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\HomeContentController::edit
 * @see app/Http/Controllers/Admin/HomeContentController.php:20
 * @route '/admin/home-content'
 */
edit.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\HomeContentController::edit
 * @see app/Http/Controllers/Admin/HomeContentController.php:20
 * @route '/admin/home-content'
 */
edit.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\HomeContentController::edit
 * @see app/Http/Controllers/Admin/HomeContentController.php:20
 * @route '/admin/home-content'
 */
    const editForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: edit.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\HomeContentController::edit
 * @see app/Http/Controllers/Admin/HomeContentController.php:20
 * @route '/admin/home-content'
 */
        editForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: edit.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\HomeContentController::edit
 * @see app/Http/Controllers/Admin/HomeContentController.php:20
 * @route '/admin/home-content'
 */
        editForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: edit.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    edit.form = editForm
/**
* @see \App\Http\Controllers\Admin\HomeContentController::update
 * @see app/Http/Controllers/Admin/HomeContentController.php:31
 * @route '/admin/home-content'
 */
export const update = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/admin/home-content',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Admin\HomeContentController::update
 * @see app/Http/Controllers/Admin/HomeContentController.php:31
 * @route '/admin/home-content'
 */
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\HomeContentController::update
 * @see app/Http/Controllers/Admin/HomeContentController.php:31
 * @route '/admin/home-content'
 */
update.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

    /**
* @see \App\Http\Controllers\Admin\HomeContentController::update
 * @see app/Http/Controllers/Admin/HomeContentController.php:31
 * @route '/admin/home-content'
 */
    const updateForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: update.url({
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'PUT',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\HomeContentController::update
 * @see app/Http/Controllers/Admin/HomeContentController.php:31
 * @route '/admin/home-content'
 */
        updateForm.put = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: update.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'PUT',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    update.form = updateForm
/**
* @see \App\Http\Controllers\Admin\HomeContentController::reset
 * @see app/Http/Controllers/Admin/HomeContentController.php:44
 * @route '/admin/home-content/reset'
 */
export const reset = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: reset.url(options),
    method: 'post',
})

reset.definition = {
    methods: ["post"],
    url: '/admin/home-content/reset',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Admin\HomeContentController::reset
 * @see app/Http/Controllers/Admin/HomeContentController.php:44
 * @route '/admin/home-content/reset'
 */
reset.url = (options?: RouteQueryOptions) => {
    return reset.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\HomeContentController::reset
 * @see app/Http/Controllers/Admin/HomeContentController.php:44
 * @route '/admin/home-content/reset'
 */
reset.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: reset.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Admin\HomeContentController::reset
 * @see app/Http/Controllers/Admin/HomeContentController.php:44
 * @route '/admin/home-content/reset'
 */
    const resetForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: reset.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\HomeContentController::reset
 * @see app/Http/Controllers/Admin/HomeContentController.php:44
 * @route '/admin/home-content/reset'
 */
        resetForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: reset.url(options),
            method: 'post',
        })
    
    reset.form = resetForm
/**
* @see \App\Http\Controllers\Admin\HomeContentController::upload
 * @see app/Http/Controllers/Admin/HomeContentController.php:57
 * @route '/admin/home-content/upload'
 */
export const upload = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: upload.url(options),
    method: 'post',
})

upload.definition = {
    methods: ["post"],
    url: '/admin/home-content/upload',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Admin\HomeContentController::upload
 * @see app/Http/Controllers/Admin/HomeContentController.php:57
 * @route '/admin/home-content/upload'
 */
upload.url = (options?: RouteQueryOptions) => {
    return upload.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\HomeContentController::upload
 * @see app/Http/Controllers/Admin/HomeContentController.php:57
 * @route '/admin/home-content/upload'
 */
upload.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: upload.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Admin\HomeContentController::upload
 * @see app/Http/Controllers/Admin/HomeContentController.php:57
 * @route '/admin/home-content/upload'
 */
    const uploadForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: upload.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\HomeContentController::upload
 * @see app/Http/Controllers/Admin/HomeContentController.php:57
 * @route '/admin/home-content/upload'
 */
        uploadForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: upload.url(options),
            method: 'post',
        })
    
    upload.form = uploadForm
const homeContent = {
    edit: Object.assign(edit, edit),
update: Object.assign(update, update),
reset: Object.assign(reset, reset),
upload: Object.assign(upload, upload),
}

export default homeContent