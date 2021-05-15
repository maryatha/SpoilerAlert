import _ from 'lodash'
import React from 'react'
import { Search, Grid, Header, Segment } from 'semantic-ui-react'
import './search.css';
import FoodCard from "./foodcard";
import source from "./source";




const initialState = {
    loading: false,
    results: [],
    value: '',
}

const getCard = (props) => {
    return(
       <FoodCard header = {props.name} meta = {props.minute} description = {props.description} />
    );
 }

function  abc (results) {
     const str = JSON.stringify(results);
     var i;
     var rows = [];
     for (i = 0; i < JSON.parse(str).length; i += 1) {
         var cur_object = results[i];
         rows.push(
             <FoodCard
                 name = {cur_object.name}
                 minute = {cur_object.minutes}
                 description = {cur_object.description}
                 contributor_id = {cur_object.contributor_id}
                 submitted = {cur_object.submitted}
                />
             );
     }
     return <div> {rows}</div>
}

function exampleReducer(state, action) {
    switch (action.type) {
        case 'CLEAN_QUERY':
            return initialState
        case 'START_SEARCH':
            return { ...state, loading: true, value: action.query }
        case 'FINISH_SEARCH':
            return { ...state, loading: false, results: action.results }
        case 'UPDATE_SELECTION':
            return { ...state, value: action.selection }

        default:
            throw new Error()
    }
}

function SearchBarFunc() {
    const [state, dispatch] = React.useReducer(exampleReducer, initialState)
    const { loading, results, value } = state

    const timeoutRef = React.useRef()

    const handleSearchChange = React.useCallback((e, data) => {
        clearTimeout(timeoutRef.current)
        dispatch({ type: 'START_SEARCH', query: data.value })

        timeoutRef.current = setTimeout(() => {
            if (data.value.length === 0) {
                dispatch({ type: 'CLEAN_QUERY' })
                return
            }

            const re = new RegExp(_.escapeRegExp(data.value), 'i')
            const isMatch = (result) => re.test(result.name)
            var a = _.filter(source, isMatch)

            for ( let  i = 0; i < a.length; i += 1) {
                a[i].title = a[i].name;
                a[i].price = a[i].minutes +  " minutes";
            }
            dispatch({
                type: 'FINISH_SEARCH',
                results: a,
            })
        }, 300)
    }, [])
    React.useEffect(() => {
        return () => {
            clearTimeout(timeoutRef.current)
        }
    }, [])

    return (
        <Grid>
            <Grid.Column width={6}>
                <Search
                    loading={loading}
                    onResultSelect={(e, data) =>
                        dispatch({ type: 'UPDATE_SELECTION', selection: data.result.name })
                    }
                    onSearchChange={handleSearchChange}
                    results={results}
                    value={value}
                />

                {abc(results)}
            </Grid.Column>
            <Grid.Column width={10}>
                <Segment>
                    <Header>State</Header>
                    <pre style={{ overflowX: 'auto' }}>
            {JSON.stringify({ loading, results, value }, null, 2)}
          </pre>
                    <Header>Options</Header>
                    <pre style={{ overflowX: 'auto' }}>
            {JSON.stringify(source, null, 2)}
          </pre>
                </Segment>
            </Grid.Column>


        </Grid>
    )
}

export default SearchBarFunc;