import React from 'react';

class OrganisationsComponents extends React.Component {
    render() {
        return (
            <div>
                <div style={{display: 'flex',  justifyContent:'center', alignItems:'center'}}>
                    <h1>Organisations</h1>
                </div>
                <div style={{display: 'flex',  justifyContent:'center'}}>
                    <ul>
                       { console.log(this.props.organisations)}
                        {this.props.organisations.map((item) => (
                            <li key={item.id}><a href={`./organisation/${item.id}/buildings`}>{item.name}</a></li>
                        ))}
                    </ul>
                </div>
            </div>
        )
    }
}

export default OrganisationsComponents;