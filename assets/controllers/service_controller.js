import { Controller } from "@hotwired/stimulus";
import $ from "jquery"; // Importa o jQuery

export default class extends Controller {
    static targets = ["servico", "range", "valueLabel", "priceDisplay"];

    connect() {
        console.log("Stimulus conectado!");

        // Carregar serviços ao conectar
        this.loadServicos();
    }

    // Busca os serviços via nova API
    loadServicos() {
        $.ajax({
            url: "/servico/api/listar", // Novo endpoint
            method: "GET",
            success: (data) => {
                this.populateServicos(data);
                this.update(); // Atualiza o valor inicial
            },
            error: (error) => {
                console.error("Erro ao carregar serviços:", error);
            },
        });
    }

    // Popula o select com os serviços carregados
    populateServicos(servicos) {
        this.servicoTarget.innerHTML = ""; // Limpa o select atual

        servicos.forEach((servico) => {
            const option = document.createElement("option");
            option.value = servico.id;
            option.textContent = `${servico.tipo} - R$ ${servico.valorUnid}/m²`;
            option.dataset.price = servico.valorUnid; // Define o preço no dataset
            this.servicoTarget.appendChild(option);
        });

        this.update(); // Atualiza o preço após carregar os serviços
    }

    // Atualiza o valor total ao alterar quantidade ou serviço
    update() {
        this.updateValueLabel();
        this.updateTotalPrice();
    }

    updateValueLabel() {
        const value = parseFloat(this.rangeTarget.value) || 0;
        this.valueLabelTarget.textContent = `${value} m²`;
    }

    updateTotalPrice() {
        const value = parseFloat(this.rangeTarget.value) || 0;

        // Captura o serviço selecionado
        const selectedOption = this.servicoTarget.selectedOptions[0];
        const pricePerSquareMeter = parseFloat(selectedOption.dataset.price) || 0;

        const totalPrice = (value * pricePerSquareMeter).toFixed(2);
        this.priceDisplayTarget.textContent = `R$ ${totalPrice}`;
    }
}
