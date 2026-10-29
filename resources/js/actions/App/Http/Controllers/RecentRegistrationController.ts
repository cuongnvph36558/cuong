import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\RecentRegistrationController::__invoke
 * @see app/Http/Controllers/RecentRegistrationController.php:17
 * @route '/registrations/recent'
 */
const RecentRegistrationController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: RecentRegistrationController.url(options),
    method: 'get',
})

RecentRegistrationController.definition = {
    methods: ["get","head"],
    url: '/registrations/recent',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\RecentRegistrationController::__invoke
 * @see app/Http/Controllers/RecentRegistrationController.php:17
 * @route '/registrations/recent'
 */
RecentRegistrationController.url = (options?: RouteQueryOptions) => {
    return RecentRegistrationController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\RecentRegistrationController::__invoke
 * @see app/Http/Controllers/RecentRegistrationController.php:17
 * @route '/registrations/recent'
 */
RecentRegistrationController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: RecentRegistrationController.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\RecentRegistrationController::__invoke
 * @see app/Http/Controllers/RecentRegistrationController.php:17
 * @route '/registrations/recent'
 */
RecentRegistrationController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: RecentRegistrationController.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\RecentRegistrationController::__invoke
 * @see app/Http/Controllers/RecentRegistrationController.php:17
 * @route '/registrations/recent'
 */
    const RecentRegistrationControllerForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: RecentRegistrationController.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\RecentRegistrationController::__invoke
 * @see app/Http/Controllers/RecentRegistrationController.php:17
 * @route '/registrations/recent'
 */
        RecentRegistrationControllerForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: RecentRegistrationController.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\RecentRegistrationController::__invoke
 * @see app/Http/Controllers/RecentRegistrationController.php:17
 * @route '/registrations/recent'
 */
        RecentRegistrationControllerForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: RecentRegistrationController.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    RecentRegistrationController.form = RecentRegistrationControllerForm
export default RecentRegistrationController