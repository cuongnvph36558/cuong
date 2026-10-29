import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Admin\LeadController::index
 * @see app/Http/Controllers/Admin/LeadController.php:19
 * @route '/admin/leads'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/leads',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\LeadController::index
 * @see app/Http/Controllers/Admin/LeadController.php:19
 * @route '/admin/leads'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\LeadController::index
 * @see app/Http/Controllers/Admin/LeadController.php:19
 * @route '/admin/leads'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\LeadController::index
 * @see app/Http/Controllers/Admin/LeadController.php:19
 * @route '/admin/leads'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\LeadController::index
 * @see app/Http/Controllers/Admin/LeadController.php:19
 * @route '/admin/leads'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\LeadController::index
 * @see app/Http/Controllers/Admin/LeadController.php:19
 * @route '/admin/leads'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\LeadController::index
 * @see app/Http/Controllers/Admin/LeadController.php:19
 * @route '/admin/leads'
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
* @see \App\Http\Controllers\Admin\LeadController::exportMethod
 * @see app/Http/Controllers/Admin/LeadController.php:61
 * @route '/admin/leads/export'
 */
export const exportMethod = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: exportMethod.url(options),
    method: 'get',
})

exportMethod.definition = {
    methods: ["get","head"],
    url: '/admin/leads/export',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\LeadController::exportMethod
 * @see app/Http/Controllers/Admin/LeadController.php:61
 * @route '/admin/leads/export'
 */
exportMethod.url = (options?: RouteQueryOptions) => {
    return exportMethod.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\LeadController::exportMethod
 * @see app/Http/Controllers/Admin/LeadController.php:61
 * @route '/admin/leads/export'
 */
exportMethod.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: exportMethod.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\LeadController::exportMethod
 * @see app/Http/Controllers/Admin/LeadController.php:61
 * @route '/admin/leads/export'
 */
exportMethod.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: exportMethod.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\LeadController::exportMethod
 * @see app/Http/Controllers/Admin/LeadController.php:61
 * @route '/admin/leads/export'
 */
    const exportMethodForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: exportMethod.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\LeadController::exportMethod
 * @see app/Http/Controllers/Admin/LeadController.php:61
 * @route '/admin/leads/export'
 */
        exportMethodForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: exportMethod.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\LeadController::exportMethod
 * @see app/Http/Controllers/Admin/LeadController.php:61
 * @route '/admin/leads/export'
 */
        exportMethodForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: exportMethod.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    exportMethod.form = exportMethodForm
/**
* @see \App\Http\Controllers\Admin\LeadController::destroy
 * @see app/Http/Controllers/Admin/LeadController.php:113
 * @route '/admin/leads/{lead}'
 */
export const destroy = (args: { lead: number | { id: number } } | [lead: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/admin/leads/{lead}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Admin\LeadController::destroy
 * @see app/Http/Controllers/Admin/LeadController.php:113
 * @route '/admin/leads/{lead}'
 */
destroy.url = (args: { lead: number | { id: number } } | [lead: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { lead: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { lead: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    lead: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        lead: typeof args.lead === 'object'
                ? args.lead.id
                : args.lead,
                }

    return destroy.definition.url
            .replace('{lead}', parsedArgs.lead.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\LeadController::destroy
 * @see app/Http/Controllers/Admin/LeadController.php:113
 * @route '/admin/leads/{lead}'
 */
destroy.delete = (args: { lead: number | { id: number } } | [lead: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

    /**
* @see \App\Http\Controllers\Admin\LeadController::destroy
 * @see app/Http/Controllers/Admin/LeadController.php:113
 * @route '/admin/leads/{lead}'
 */
    const destroyForm = (args: { lead: number | { id: number } } | [lead: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: destroy.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'DELETE',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\LeadController::destroy
 * @see app/Http/Controllers/Admin/LeadController.php:113
 * @route '/admin/leads/{lead}'
 */
        destroyForm.delete = (args: { lead: number | { id: number } } | [lead: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: destroy.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'DELETE',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    destroy.form = destroyForm
const leads = {
    index: Object.assign(index, index),
export: Object.assign(exportMethod, exportMethod),
destroy: Object.assign(destroy, destroy),
}

export default leads