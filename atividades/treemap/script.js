const gamesDataUrl = 'https://cdn.freecodecamp.org/testable-projects-fcc/data/tree_map/video-game-sales-data.json';
let gamesData;

const canvas = d3.select('#canvas');
const tooltip = d3.select('#tooltip');

const drawTreeMap = () => {
    const hierarchy = d3.hierarchy(gamesData, node => node.children)
        .sum(node => node.value)
        .sort((a, b) => b.value - a.value);

    const createTreeMap = d3.treemap().size([1000, 600]);
    createTreeMap(hierarchy);

    const gamesTiles = hierarchy.leaves();

    const colorScale = {
        'Wii': 'orange',
        'NES': 'lightgreen',
        'GB': 'coral',
        'DS': 'lightblue',
        'X360': 'green',
        'PS3': 'blue',
        'PS2': 'red',
        'SNES': 'pink',
        'GBA': 'tan',
        'PS4': 'khaki',
        '3DS': 'yellow',
        'N64': 'purple',
        'PS': 'grey',
        'XB': 'darkgreen',
        'PC': 'darkblue',
        'PSP': 'darkred',
        'XOne': 'teal',
        '2600': 'lightyellow'
    };

    const block = canvas.selectAll('g')
        .data(gamesTiles)
        .enter()
        .append('g')
        .attr('transform', game => `translate(${game.x0}, ${game.y0})`);

    block.append('rect')
        .attr('class', 'tile')
        .attr('fill', game => colorScale[game.data.category] || 'black')
        .attr('data-name', game => game.data.name)
        .attr('data-category', game => game.data.category)
        .attr('data-value', game => game.data.value)
        .attr('width', game => game.x1 - game.x0)
        .attr('height', game => game.y1 - game.y0)
        .on('mouseover', game => {
            tooltip.transition().style('visibility', 'visible');
            const revenue = game.data.value.toLocaleString();
            tooltip.html(`$ ${revenue}<hr />${game.data.name}`)
                .attr('data-value', game.data.value);
        })
        .on('mouseout', () => tooltip.transition().style('visibility', 'hidden'));

    block.append('text')
        .text(game => game.data.name)
        .attr('x', 5)
        .attr('y', 20)
        .style('font-size', game => {
            const blockWidth = game.x1 - game.x0;
            const blockHeight = game.y1 - game.y0;
            const textLength = game.data.name.length;

            // Ajustar o tamanho da fonte baseado na área do bloco e no comprimento do texto
            const fontSize = Math.min(blockWidth / textLength, blockHeight / 2);
            return `${fontSize}px`;
        })
        .each(function(game) {
            // Ajuste de linha para texto que excede a largura do bloco
            const text = d3.select(this);
            const words = game.data.name.split(/\s+/).reverse();
            let word;
            let line = [];
            let lineNumber = 0;
            let lineHeight = 1.1; // em
            let y = text.attr("y");
            let dy = parseFloat(text.attr("dy"));
            let tspan = text.text(null).append("tspan").attr("x", 5).attr("y", y).attr("dy", `${dy}em`);
            while (word = words.pop()) {
                line.push(word);
                tspan.text(line.join(" "));
                if (tspan.node().getComputedTextLength() > game.x1 - game.x0) {
                    line.pop();
                    tspan.text(line.join(" "));
                    line = [word];
                    tspan = text.append("tspan").attr("x", 5).attr("y", y).attr("dy", `${++lineNumber * lineHeight}em`).text(word);
                }
            }
        });
};

d3.json(gamesDataUrl).then(data => {
    gamesData = data;
    drawTreeMap();
}).catch(error => console.log(error));
