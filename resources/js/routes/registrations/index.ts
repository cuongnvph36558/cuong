import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\RecentRegistrationController::__invoke
 * @see app/Http/Controllers/RecentRegistrationController.php:17
 * @route '/registrations/recent'
 */
export const recent = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: recent.url(options),
    method: 'get',
})

recent.definition = {
    methods: ["get","head"],
    url: '/registrations/recent',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\RecentRegistrationController::__invoke
 * @see app/Http/Controllers/RecentRegistrationController.php:17
 * @route '/registrations/recent'
 */
recent.url = (options?: RouteQueryOptions) => {
    return recent.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\RecentRegistrationController::__invoke
 * @see app/Http/Controllers/RecentRegistrationController.php:17
 * @route '/registrations/recent'
 */
recent.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: recent.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\RecentRegistrationController::__invoke
 * @see app/Http/Controllers/RecentRegistrationController.php:17
 * @route '/registrations/recent'
 */
recent.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: recent.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\RecentRegistrationController::__invoke
 * @see app/Http/Controllers/RecentRegistrationController.php:17
 * @route '/registrations/recent'
 */
    const recentForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: recent.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\RecentRegistrationController::__invoke
 * @see app/Http/Controllers/RecentRegistrationController.php:17
 * @route '/registrations/recent'
 */
        recentForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: recent.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\RecentRegistrationController::__invoke
 * @see app/Http/Controllers/RecentRegistrationController.php:17
 * @route '/registrations/recent'
 */
        recentForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: recent.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    recent.form = recentForm
const registrations = {
    recent: Object.assign(recent, recent),
}

export default registrations