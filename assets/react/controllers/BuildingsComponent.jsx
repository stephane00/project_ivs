import React from 'react';

class BuildingsComponent extends React.Component {
        constructor(props) {
        super(props);
        this.state = {data: null};
    }

    async myAsyncFunction() {
        const response = await fetch(`/organisation/${this.props.id}/buildingsJSON`);
        const data = await response.json();
        this.setState({data});
    }

    componentDidMount() {
        this.myAsyncFunction();
    }

    render() {
        let $i = 0;
        const { data } = this.state;

        if (!data) {
          return <div>Loading...</div>;
        }
        return (
            <div>
                <div>
                    <h2>List of Buildings in this organisation - {data[0].nameOrganisation} :</h2>
                </div>
                <div>
                    {data ? (
                        <ul>
                            {data.map((item) => (
                                <div key={item.id}>
                                    
                                    <li><a href={`/organisation/${this.props.id}/building/${item.id}/pieces`}>{item.name}</a></li>
                                     <p>nombre totale de personne présente dans le building {/*item.personnesBuilding[$i++]*/}</p>
                                 </div>
                            ))}
                        </ul>
                    ) : (
                        <p>Loading...</p>
                    )}
                </div>
            </div>
        )
    }
}

export default BuildingsComponent;